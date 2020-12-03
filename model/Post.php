<?php

class Post
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $comments;

    public function __construct($id = NULL, $title = NULL, $content = NULL, User $author = NULL, array $comments = NULL)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
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
}
