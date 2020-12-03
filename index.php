<?php

define("DEFAULT_CONTROLLER", "posts");
define("DEFAULT_ACTION", "index");

function getControllerClassName($controllerName)
{
    return strToUpper(substr($controllerName, 0, 1)) . substr($controllerName, 1) . "Controller";
}

function loadController($controllerName)
{
    $controllerClassName = getControllerClassName($controllerName);
    require_once(__DIR__ . "/controller/" . $controllerClassName . ".php");
    return new $controllerClassName();
}

function main()
{
    try {
        if (!isset($_GET["controller"])) {
            $_GET["controller"] = DEFAULT_CONTROLLER;
        }

        if (!isset($_GET["action"])) {
            $_GET["action"] = DEFAULT_ACTION;
        }

        $controller = loadController($_GET["controller"]);
        $action = $_GET["action"];
        $controller->$action();
    } catch (Exception $ex) {
        die("Error occured!" . $ex->getMessage());
    }
}

main();
