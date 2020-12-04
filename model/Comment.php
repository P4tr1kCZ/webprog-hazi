<?php

require_once(__DIR__ . "/../utils/ValidationException..php");

class Comment
{
    private $id;
    private $content;
    private $author;
    private $post;
    private $created;

    public function __construct($id = NULL, $content = NULL, User $author = NULL, $created = NULL, Post $post = NULL)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->post = $post;
        $this->created = $created;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function validateBeforeCreate()
    {
        $errors = array();

        if (strlen(trim($this->content)) < 2) {
            $errors["content"] = "content is mandatory";
        }
        if ($this->author == NULL) {
            $errors["author"] = "author is mandatory";
        }
        if ($this->post == NULL) {
            $errors["post"] = "post is mandatory";
        }

        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "comment is not valid");
        }
    }
}
