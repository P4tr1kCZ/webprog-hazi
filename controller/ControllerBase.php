<?php

require_once(__DIR__ . "/../utils/ViewManager.php");
require_once(__DIR__ . "/../model/User.php");

class ControllerBase
{
    protected $view;
    protected $currentUser;

    public function __construct()
    {
        $this->view = ViewManager::getInstance();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


        if (isset($_SESSION["currentuser"])) {

            $this->currentUser = new User($_SESSION["currentuser"]);
            //add current user to the view, since some views require it
            $this->view->setVariable(
                "currentusername",
                $this->currentUser->getUsername()
            );
        }
    }
}
