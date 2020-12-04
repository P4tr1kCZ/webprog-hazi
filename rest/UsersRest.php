<?php

require_once(__DIR__ . "/Rest.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../db/DbUsers.php");
require_once(__DIR__ . "/../utils/ValidationException..php");

class UsersRest extends Rest
{
    private $dbUsers;

    public function __construct()
    {
        parent::__construct();
        $this->dbUsers = new DbUsers();
    }

    public function postUser($data)
    {
        $user = new User($data->username, $data->password);
        try {
            $user->validateBeforeRegister();
            $this->dbUsers->insert($user);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            header("Location: " . $_SERVER['REQUEST_URI'] . "/" . $data->username);
        } catch (ValidationException $ex) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo (json_encode($ex->getErrors()));
        }
    }

    function login($username)
    {
        $currentUser = parent::authenticate();
        if ($currentUser->getUsername() != $username) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            echo ("You are not authorized to login as anyone but you");
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
            echo ("Hello " . $username);
        }
    }
}