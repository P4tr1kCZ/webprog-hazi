<?php

require_once(__DIR__ . "/PDOConnection.php");
require_once(__DIR__ . "/../model/Comment.php");

class DbComments
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function insert(Comment $comment)
    {
        $query = $this->db->prepare("INSERT INTO comments(content, author, post, created) values (?,?,?,?)");
        $query->execute(array($comment->getContent(), $comment->getAuthor()->getUsername(), $comment->getPost()->getId(), $comment->getCreated()));
        return $this->db->lastInsertId();
    }
}
