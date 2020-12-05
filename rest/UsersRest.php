<?php

require_once(__DIR__ . "/Rest.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../db/DbUsers.php");
require_once(__DIR__ . "/../utils/ValidationException.php");

class UsersRest extends Rest
{
    private $dbUsers;

    public function __construct()
    {
        parent::__construct();
        $this->dbUsers = new DbUsers();
    }

    public function getAll()
    {
        $users = $this->dbUsers->findAll();
        $users_array = array();
        $i = 1;
        foreach ($users as $user) {
            array_push($users_array, array(
                "id" => $i++,
                "username" => $user->getUsername(),
                "role" => $user->getRole(),
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($users_array));
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

$usersRest = new UsersRest();
URIDispatcher::getInstance()
    ->map("GET",    "/users", array($usersRest, "getAll"))
    ->map("GET",    "/users/$1", array($usersRest, "login"))
    ->map("POST", "/users", array($usersRest, "postUser"));
