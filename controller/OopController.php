<?php

require_once(__DIR__ . "/ControllerBase.php");

class OopController extends ControllerBase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render("oop", "index");
    }
}
