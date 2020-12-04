<?php

require_once(__DIR__ . "/ControllerBase.php");

class ApiController extends ControllerBase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function rest()
    {
        $this->view->render("apis", "rest");
    }

    public function soap()
    {
        $this->view->render("apis", "soap");
    }
}
