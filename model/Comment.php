<?php

class Comment
{
    private $id;
    private $content;
    private $author;
    private $post;

    public function __construct($id = NULL, $content = NULL, User $author = NULL, Post $post = NULL)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->post = $post;
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
}
