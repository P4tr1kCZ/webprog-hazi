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
            $this->view->setVariable(
                "currentuser",
                $this->currentUser->getUsername()
            );
        }
    }
}
