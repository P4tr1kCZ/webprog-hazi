<?php

require_once(__DIR__ . "/PDOConnection.php");

require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Post.php");
require_once(__DIR__ . "/../model/Comment.php");

class DbPosts
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function findAll()
    {
        $query = $this->db->query("SELECT * FROM posts, users WHERE users.username = posts.author");
        $posts_db = $query->fetchAll(PDO::FETCH_ASSOC);

        $posts = array();

        foreach ($posts_db as $post) {
            $author = new User($post["username"]);
            array_push($posts, new Post($post["id"], $post["title"], $post["content"], $author));
        }

        return $posts;
    }

    public function findById($postid)
    {
        $query = $this->db->prepare("SELECT * FROM posts WHERE id=?");
        $query->execute(array($postid));
        $post = $query->fetch(PDO::FETCH_ASSOC);

        if ($post != null) {
            return new Post(
                $post["id"],
                $post["title"],
                $post["content"],
                new User($post["author"])
            );
        } else {
            return NULL;
        }
    }

    public function findByIdWithComments($postid)
    {
        $query = $this->db->prepare("SELECT
			P.id as 'post.id',
			P.title as 'post.title',
			P.content as 'post.content',
			P.author as 'post.author',
			C.id as 'comment.id',
			C.content as 'comment.content',
			C.post as 'comment.post',
			C.author as 'comment.author'

			FROM posts P LEFT OUTER JOIN comments C
			ON P.id = C.post
			WHERE
			P.id=? ");

        $query->execute(array($postid));
        $post_wt_comments = $query->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($post_wt_comments) > 0) {
            $post = new Post(
                $post_wt_comments[0]["post.id"],
                $post_wt_comments[0]["post.title"],
                $post_wt_comments[0]["post.content"],
                new User($post_wt_comments[0]["post.author"])
            );
            $comments_array = array();
            if ($post_wt_comments[0]["comment.id"] != null) {
                foreach ($post_wt_comments as $comment) {
                    $comment = new Comment(
                        $comment["comment.id"],
                        $comment["comment.content"],
                        new User($comment["comment.author"]),
                        $post
                    );
                    array_push($comments_array, $comment);
                }
            }
            $post->setComments($comments_array);

            return $post;
        } else {
            return NULL;
        }
    }

    public function insert(Post $post)
    {
        $query = $this->db->prepare("INSERT INTO posts(title, content, author) values (?,?,?)");
        $query->execute(array($post->getTitle(), $post->getContent(), $post->getAuthor()->getUsername()));
        return $this->db->lastInsertId();
    }

    public function update(Post $post)
    {
        $query = $this->db->prepare("UPDATE posts set title=?, content=? where id=?");
        $query->execute(array($post->getTitle(), $post->getContent(), $post->getId()));
    }

    public function delete(Post $post)
    {
        $query = $this->db->prepare("DELETE from posts WHERE id=?");
        $query->execute(array($post->getId()));
    }
}
