<?php

require_once(__DIR__ . "/ControllerBase.php");
require_once(__DIR__ . "/../db/DbPosts.php");
require_once(__DIR__ . "/../utils/Localization.php");

require_once(__DIR__ . "/../model/Comment.php");
require_once(__DIR__ . "/../model/Post.php");
require_once(__DIR__ . "/../model/User.php");

class PostsController extends ControllerBase
{
    private $dbPosts;

    public function __construct()
    {
        parent::__construct();

        $this->dbPosts = new DbPosts();
    }

    public function getAll()
    {
        $posts = $this->dbPosts->findAll();
        $this->view->setVariable("posts", $posts);
        $this->view->render("posts", "index");
    }

    public function view()
    {
        if (!isset($_GET["id"])) {
            throw new Exception("id is mandatory");
        }

        $postid = $_GET["id"];
        $post = $this->dbPosts->findByIdWithComments($postid);
        if ($post == NULl) {
            throw new Exception("No such post with id: " . $postid);
        }

        $this->view->setVariable("post", $post);
        $comment =  $this->view->getVariable("comment");
        $this->view->setVariable("comment", ($comment == NULL) ? new Comment() : $comment);
        $this->view->render("posts", "view");
    }

    public function add()
    {
        if (!isset($this->currentUser)) {
            throw new Exception("Not in session. Adding posts requires login");
        }

        $post = new Post();

        if (isset($_POST["submit"])) {
            $post->setTitle($_POST["title"]);
            $post->setContent($_POST["content"]);
            $post->setAuthor($this->currentUser);

            try {
                $post->validateBeforeCreate();
                $this->dbPosts->insert($post);
                $this->view->setFlash(sprintf(i18n("Post \"%s\" successfully added."), $post->getTitle()));
                $this->view->redirect("posts", "index");
            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors", $errors);
            }
        }

        $this->view->setVariable("post", $post);
        $this->view->render("posts", "add");
    }

    public function edit()
    {
        if (!isset($_REQUEST["id"])) {
            throw new Exception("A post id is mandatory");
        }

        if (!isset($this->currentUser)) {
            throw new Exception("Not in session. Editing posts requires login");
        }

        $postid = $_REQUEST["id"];
        $post = $this->dbPosts->findById($postid);

        if ($post == NULL) {
            throw new Exception("no such post with id: " . $postid);
        }

        if ($post->getAuthor() != $this->currentUser) {
            throw new Exception("logged user is not the author of the post id " . $postid);
        }

        if (isset($_POST["submit"])) {
            $post->setTitle($_POST["title"]);
            $post->setContent($_POST["content"]);
            try {
                $post->validateBeforeUpdate();
                $this->dbPosts->update($post);
                $this->view->setFlash(sprintf(i18n("Post \"%s\" successfully updated."), $post->getTitle()));
                $this->view->redirect("posts", "index");
            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors", $errors);
            }
        }

        $this->view->setVariable("post", $post);
        $this->view->render("posts", "edit");
    }

    public function delete()
    {
        if (!isset($_POST["id"])) {
            throw new Exception("id is mandatory");
        }
        if (!isset($this->currentUser)) {
            throw new Exception("Not in session. Editing posts requires login");
        }

        $postid = $_REQUEST["id"];
        $post = $this->postMapper->findById($postid);

        if ($post == NULL) {
            throw new Exception("no such post with id: " . $postid);
        }

        if ($post->getAuthor() != $this->currentUser) {
            throw new Exception("Post author is not the logged user");
        }

        $this->dbPosts->delete($post);
        $this->view->setFlash(sprintf(i18n("Post \"%s\" successfully deleted."), $post->getTitle()));
        $this->view->redirect("posts", "index");
    }
}
