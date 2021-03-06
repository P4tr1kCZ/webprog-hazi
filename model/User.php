<?php

require_once(__DIR__ . "/../utils/ValidationException.php");

class User
{
    private $username;
    private $password;
    private $role;

    public function __construct($username = NULL, $password = NULL, $role = NULL)
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
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

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
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
        if ($this->role != "USER") {
            $errors["role"] = "You can register only USER type accounts";
        }
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "User is not valid.");
        }
    }
}
