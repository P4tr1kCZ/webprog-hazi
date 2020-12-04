<?php

require_once(__DIR__ . "/ControllerBase.php");
require_once(__DIR__ . "/../db/DbUsers.php");
require_once(__DIR__ . "/../model/User.php");

class UsersController extends ControllerBase
{
    private $dbUsers;

    public function __construct()
    {
        parent::__construct();
        $this->dbUsers = new DbUsers();
    }

    public function login()
    {
        if (isset($_POST["username"])) {
            if ($this->dbUsers->isValidUser($_POST["username"], $_POST["password"])) {
                $_SESSION["currentuser"] = $_POST["username"];
                $this->view->redirect("posts", "index");
            } else {
                $errors = array();
                $errors["general"] = "Username is not valid";
                $this->view->setVariable("errors", $errors);
            }
        }

        $this->view->render("users", "login");
    }

    public function register()
    {
        $user = new User();

        if (isset($_POST["username"])) {
            $user->setUsername($_POST["username"]);
            $user->setPassword($_POST["password"]);


            try {

                $user->validateBeforeRegister();

                if (!$this->dbUsers->usernameExists($_POST["username"])) {
                    $this->dbUsers->insert($user);
                    $this->view->setFlash("Username " . $user->getUsername() . " successfully added. Please login now");
                    $this->view->redirect("users", "login");
                } else {
                    $errors = array();
                    $errors["username"] = "Username already exists";
                    $this->view->setVariable("errors", $errors);
                }
            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors", $errors);
            }
        }

        $this->view->setVariable("user", $user);
        $this->view->render("users", "register");
    }

    public function logout()
    {
        session_destroy();
        $this->view->redirect("users", "login");
    }
}
