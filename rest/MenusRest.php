<?php

require_once(__DIR__ . "/Rest.php");

require_once(__DIR__ . "/../model/Menu.php");

require_once(__DIR__ . "/../db/DbMenus.php");

class MenusRest extends Rest
{
    private $dbMenus;

    public function __construct()
    {
        parent::__construct();
        $this->dbMenus = new DbMenus();
    }

    public function getMenus()
    {
        $menus = $this->dbMenus->findAll();
        $menus_array = array();
        foreach ($menus as $menu) {
            array_push($menus_array, array(
                "id" => $menu->getId(),
                "name" => $menu->getName(),
                "parentid" => $menu->getParentId(),
                "controller" => $menu->getController(),
                "action" => $menu->getAction(),
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($menus_array));
    }

    public function getChildren($parentId)
    {
        $menus = $this->dbMenus->getChildren($parentId);
        $menus_array = array();
        foreach ($menus as $menu) {
            array_push($menus_array, array(
                "id" => $menu->getId(),
                "name" => $menu->getName(),
                "parentid" => $menu->getParentId(),
                "controller" => $menu->getController(),
                "action" => $menu->getAction(),
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($menus_array));
    }


    public function getParents()
    {
        $menus = $this->dbMenus->getParents();
        $menus_array = array();
        foreach ($menus as $menu) {
            array_push($menus_array, array(
                "id" => $menu->getId(),
                "name" => $menu->getName(),
                "parentid" => $menu->getParentId(),
                "controller" => $menu->getController(),
                "action" => $menu->getAction(),
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($menus_array));
    }

    public function getByName($name)
    {
        $menu = $this->dbMenus->findByName($name);

        if ($menu == NULL) {
            header($_SERVER['SERVER_PROTOCOL'] . '400 Bad request');
            echo ("Menu with name " . $name . " not found");
            return;
        }

        $menu_array = array(
            "id" => $menu->getId(),
            "name" => $menu->getName(),
            "parentid" => $menu->getParentId(),
            "controller" => $menu->getController(),
            "action" => $menu->getAction(),
        );

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($menu_array));
    }
}

$menusRest = new MenusRest();
URIDispatcher::getInstance()
    ->map("GET", "/menus", array($menusRest, "getMenus"))
    ->map("GET", "/menus/$1/children", array($menusRest, "getChildren"))
    ->map("GET", "/menus/parents", array($menusRest, "getParents"))
    ->map("GET", "/menus/$1", array($menusRest, "getByName"));
