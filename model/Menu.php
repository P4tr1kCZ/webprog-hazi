<?php

class Menu
{
    private $id;
    private $name;
    private $parentId;

    public function __construct($id = NULL, $name = NULL, $parentId = NULL)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
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
}
