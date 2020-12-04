<?php

class Menu
{
    private $id;
    private $name;
    private $parentId;
    private $controller;
    private $action;

    public function __construct($id = NULL, $name = NULL, $parentId = NULL, $controller = NULL, $action)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }
}
