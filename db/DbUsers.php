<?php

require_once(__DIR__ . "/PDOConnection.php");
require_once(__DIR__ . "/../model/User.php");

class DbUsers
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function findAll()
    {
        $query = $this->db->query("SELECT username, role FROM users");
        $users_db = $query->fetchAll(PDO::FETCH_ASSOC);

        $users = array();

        foreach ($users_db as $user) {
            array_push($users, new User($user["username"], "", $user["role"]));
        }

        return $users;
    }

    public function findByName($username)
    {
        $query = $this->db->prepare("SELECT username, role FROM users WHERE username=?");
        $query->execute(array($username));
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user != null) {
            return new User($user["username"], "", $user["role"]);
        } else {
            return NULL;
        }
    }

    public function findRoleByName($username)
    {
        $query = $this->db->prepare("SELECT role FROM users WHERE username=?");
        $query->execute(array($username));
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user["role"];
    }

    public function insert($user)
    {
        $query = $this->db->prepare("INSERT INTO users values (?,?,?)");
        $query->execute(array($user->getUsername(), password_hash($user->getPassword(), PASSWORD_BCRYPT), $user->getRole()));
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
        $query = $this->db->prepare("SELECT username,password FROM users where username=:username");
        $query->bindParam(':username', $username);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);

        if ($results && count($results) > 0 && password_verify($password, $results['password'])) {
            return true;
        }
    }
}
