<?php

require_once(__DIR__ . "/../utils/ValidationException..php");

class User
{
    private $username;
    private $password;

    public function __construct($username = NULL, $password = NULL)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function validateBeforeRegister()
    {
        $errors = array();
        if (strlen($this->username) < 5) {
            $errors["username"] = "Username must be at least 5 characters length";
        }
        if (strlen($this->password) < 5) {
            $errors["password"] = "Password must be at least 5 characters length";
        }
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "user is not valid");
        }
    }
}
