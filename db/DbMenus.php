<?php

require_once(__DIR__ . "/PDOConnection.php");

require_once(__DIR__ . "/../model/Menu.php");

class DbMenus
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function findAll()
    {
        $query = $this->db->query("SELECT * FROM menus");
        $menus_db = $query->fetchAll(PDO::FETCH_ASSOC);

        $menus = array();

        foreach ($menus_db as $menu) {
            array_push($menus, new Menu($menu["id"], $menu["name"], $menu["parentid"], $menu["controller"], $menu["action"]));
        }

        return $menus;
    }

    public function getChildren($parentId)
    {
        $query = $this->db->prepare("SELECT * FROM menus WHERE parentid=?");
        $query->execute(array($parentId));
        $menus_db = $query->fetchAll(PDO::FETCH_ASSOC);
        $menus = array();
        foreach ($menus_db as $menu) {
            array_push($menus, new Menu($menu["id"], $menu["name"], $menu["parentid"], $menu["controller"], $menu["action"]));
        }

        return $menus;
    }

    public function getParents()
    {
        $query = $this->db->prepare("SELECT * FROM menus WHERE parentid is null");
        $query->execute();
        $menus_db = $query->fetchAll(PDO::FETCH_ASSOC);
        $menus = array();
        foreach ($menus_db as $menu) {
            array_push($menus, new Menu($menu["id"], $menu["name"], $menu["parentid"], $menu["controller"], $menu["action"]));
        }

        return $menus;
    }

    public function findById($menuid)
    {
        $query = $this->db->prepare("SELECT * FROM menus WHERE id=?");
        $query->execute(array($menuid));
        $menu = $query->fetch(PDO::FETCH_ASSOC);

        if ($menu != null) {
            return new Menu(
                $menu["id"],
                $menu["name"],
                $menu["parentid"],
                $menu["controller"],
                $menu["action"]
            );
        } else {
            return NULL;
        }
    }

    public function findByName($menuName)
    {
        $query = $this->db->prepare("SELECT * FROM menus WHERE name=?");
        $query->execute(array($menuName));
        $menu = $query->fetch(PDO::FETCH_ASSOC);

        if ($menu != null) {
            return new Menu(
                $menu["id"],
                $menu["name"],
                $menu["parentid"],
                $menu["controller"],
                $menu["action"]
            );
        } else {
            return NULL;
        }
    }
}

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
