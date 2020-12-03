<?php

require_once(__DIR__ . "/PDOConnection.php");

class DbUsers
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function insert($user)
    {
        $query = $this->db->prepare("INSERT INTO users values (?,?)");
        $query->execute(array($user->getUsername(), $user->getPassword()));
    }

    public function usernameExists($username)
    {
        $query = $this->db->prepare("SELECT count(username) FROM users where username=?");
        $query->execute(array($username));

        if ($query->fetchColumn() > 0) {
            return true;
        }
    }

    public function isValidUser($username, $password)
    {
        $query = $this->db->prepare("SELECT count(username) FROM users where username=? and password=?");
        $query->execute(array($username, $password));

        if ($query->fetchColumn() > 0) {
            return true;
        }
    }
}
