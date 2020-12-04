<?php

require_once(__DIR__ . "/BaseRest.php");

require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Post.php");
require_once(__DIR__ . "/../model/Comment.php");

require_once(__DIR__ . "/../db/DbUsers.php");
require_once(__DIR__ . "/../db/DbPosts.php");
require_once(__DIR__ . "/../db/DbComments.php");

class PostsRest extends Rest
{
    private $dbPosts;
    private $dbComments;

    public function __construct()
    {
        parent::__construct();
        $this->dbPosts = new DbPosts();
        $this->dbComments = new DbComments();
    }

    public function getPosts()
    {
        $posts = $this->dbPosts->findAll();
        $posts_array = array();
        foreach ($posts as $post) {
            array_push($posts_array, array(
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "content" => $post->getContent(),
                "author" => $post->getAuthor()->getUsername(),
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($posts_array));
    }

    public function createPost($data)
    {
        $currentUser = parent::authenticate();
        $post = new Post();

        if (isset($data->title) && isset($data->content)) {
            $post->setTitle($data->title);
            $post->setContent($data->content);
            $post->setAuthor($currentUser);
        }

        try {
            $post->validateBeforeCreate();
            $postId = $this->dbPosts->insert($post);

            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            header('Location: ' . $_SERVER['REQUEST_URI'] . "/" . $postId);
            header('Content-Type: application/json');
            echo (json_encode(array(
                "id" => $postId,
                "title" => $post->getTitle(),
                "content" => $post->getContent(),
            )));
        } catch (ValidationException $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad request');
            header('Content-Type: application/json');
            echo (json_encode($e->getErrors()));
        }
    }

    public function getPost($postId)
    {
        $post = $this->dbPosts->findByIdWithComments($postId);

        if ($post == NULL) {
            header($_SERVER['SERVER_PROTOCOL'] . '400 Bad request');
            echo ("Post with id " . $postId . " not found");
            return;
        }

        $post_array = array(
            "id" => $post->getId(),
            "title" => $post->getTitle(),
            "content" => $post->getContent(),
            "author" => $post->getAuthor()->getusername(),

        );

        $post_array["comments"] = array();
        foreach ($post->getComments() as $comment) {
            array_push($post_array["comments"], array(
                "id" => $comment->getId(),
                "content" => $comment->getContent(),
                "author" => $comment->getAuthor()->getusername(),
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($post_array));
    }

    public function updatePost($postId, $data)
    {
        $currentUser = parent::authenticate();
        $post = $this->dbPosts->findById($postId);

        if ($post == NULL) {
            header($_SERVER['SERVER_PROTOCOL'] . '400 Bad request');
            echo ("Post with id " . $postId . " not found");
            return;
        }

        if ($post->getAuthor() != $currentUser) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            echo ("you are not the author of this post");
            return;
        }

        $post->setTitle($data->title);
        $post->setContent($data->content);

        try {
            $post->validateBeforeUpdate();
            $this->postMapper->update($post);
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        } catch (ValidationException $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad request');
            header('Content-Type: application/json');
            echo (json_encode($e->getErrors()));
        }
    }

    public function deletePost($postId)
    {
        $currentUser = parent::authenticate();
        $post = $this->dbPosts->findById($postId);

        if ($post == NULL) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad request');
            echo ("Post with id " . $postId . " not found");
            return;
        }

        if ($post->getAuthor() != $currentUser) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            echo ("you are not the author of this post");
            return;
        }

        $this->dbPosts->delete($post);
        header($_SERVER['SERVER_PROTOCOL'] . ' 204 No Content');
    }

    public function createComment($postId, $data)
    {
        $currentUser = parent::authenticate();
        $post = $this->dbPosts->findById($postId);

        if ($post == NULL) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad request');
            echo ("Post with id " . $postId . " not found");
            return;
        }

        $comment = new Comment();
        $comment->setContent($data->content);
        $comment->setAuthor($currentUser);
        $comment->setPost($post);

        try {
            $comment->validateBeforeCreate();
            $this->dbComments->insert($comment);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
        } catch (ValidationException $ex) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad request');
            header('Content-Type: application/json');
            echo (json_encode($ex->getErrors()));
        }
    }
}

$postsRest = new PostsRest();
URIDispatcher::getInstance()
    ->map("GET",    "/post", array($postRest, "getPosts"))
    ->map("GET",    "/post/$1", array($postRest, "getPost"))
    ->map("POST", "/post", array($postRest, "createPost"))
    ->map("POST", "/post/$1/comment", array($postRest, "createComment"))
    ->map("PUT",    "/post/$1", array($postRest, "updatePost"))
    ->map("DELETE", "/post/$1", array($postRest, "deletePost"));
