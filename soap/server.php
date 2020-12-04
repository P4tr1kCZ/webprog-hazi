<?php

require_once(__DIR__ . "/../db/DbUsers.php");

class Soap
{
    private $dbUsers;

    public function __construct()
    {
        $this->dbUsers = new DbUsers();
    }

    public function getUserName($username)
    {
        $user = $this->dbUsers->findByName($username);

        $xmlr = new SimpleXMLElement("<User></User>");
        $xmlr->addChild('username', $user->getUsername());
        $xmlr->addChild('role', $user->getRole());
        $xmlresult = $xmlr->asXML();
        return $xmlresult;
    }
}

$params = array('uri' => '/soap/server.php');
$server = new SoapServer(NULL, $params);
$server->setClass("Soap");
$server->handle();
