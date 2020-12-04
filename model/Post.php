<?php

require_once(__DIR__ . "/../utils/ValidationException..php");

class Post
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $comments;
    private $created;

    public function __construct($id = NULL, $title = NULL, $content = NULL, $created = NULL, User $author = NULL, array $comments = NULL)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->created = $created;
        $this->author = $author;
        $this->comments = $comments;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments(array $comments)
    {
        $this->comments = $comments;
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
        if (strlen(trim($this->title)) == 0) {
            $errors["title"] = "title is mandatory";
        }
        if (strlen(trim($this->content)) == 0) {
            $errors["content"] = "content is mandatory";
        }
        if ($this->author == NULL) {
            $errors["author"] = "author is mandatory";
        }

        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "post is not valid");
        }
    }

    public function validateBeforeUpdate()
    {
        $errors = array();

        if (!isset($this->id)) {
            $errors["id"] = "id is mandatory";
        }

        try {
            $this->validateBeforeCreate();
        } catch (ValidationException $ex) {
            foreach ($ex->getErrors() as $key => $error) {
                $errors[$key] = $error;
            }
        }
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "post is not valid");
        }
    }
}
