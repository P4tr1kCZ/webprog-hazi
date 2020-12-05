<?php

require_once(__DIR__ . "/ControllerBase.php");
require_once(__DIR__ . "/../db/DbPosts.php");
require_once(__DIR__ . "/../db/DbComments.php");

require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/Post.php");
require_once(__DIR__ . "/../model/Comment.php");

class CommentsController extends ControllerBase
{
    private $dbComments;
    private $dbPosts;

    public function __construct()
    {
        parent::__construct();

        $this->dbComments = new DbComments();
        $this->dbPosts = new DbPosts();
    }

    public function add()
    {
        if (!isset($this->currentUser)) {
            throw new Exception("Not in session. Adding posts requires login");
        }

        if (isset($_POST["id"])) {

            $postid = $_POST["id"];
            $post = $this->dbPosts->findById($postid);

            if ($post == NULL) {
                throw new Exception("no such post with id: " . $postid);
            }

            $comment = new Comment();
            $comment->setContent($_POST["content"]);
            $comment->setAuthor($this->currentUser);
            $comment->setPost($post);
            $comment->setCreated(date('Y-m-d H:i:s'));

            try {
                $comment->validateBeforeCreate();
                $this->dbComments->insert($comment);
                $this->view->redirect("posts", "view", "id=" . $post->getId());
            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("comment", $comment, true);
                $this->view->setVariable("errors", $errors, true);
                $this->view->redirect("posts", "view", "id=" . $post->getId());
            }
        } else {
            throw new Exception("No such post id");
        }
    }
}
