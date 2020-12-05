<?php

require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../db/DbUsers.php");

class Rest
{
    public function __construct()
    {
    }

    public function authenticate()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Rest API of MVCBLOG"');
            die('This operation requires authentication');
        } else {
            $dbUsers = new DbUsers();
            if ($dbUsers->isValidUser(
                $_SERVER['PHP_AUTH_USER'],
                $_SERVER['PHP_AUTH_PW']
            )) {

                return new User($_SERVER['PHP_AUTH_USER']);
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized');
                header('WWW-Authenticate: Basic realm="Rest API of MVCBLOG"');

                die('The username/password is not valid.');
            }
        }
    }
}
