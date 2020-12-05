<?php

class ViewManager
{
    const DEFAULT_FRAGMENT = "__default__";
    private $fragmentContents = array();
    private $variables = array();
    private $currentFragment = self::DEFAULT_FRAGMENT;
    private $layout = "layout";

    private function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        ob_start();
    }

    private function saveCurrentFragment()
    {
        $this->fragmentContents[$this->currentFragment] .= ob_get_contents();
        ob_clean();
    }

    public function moveToFragment($name)
    {
        $this->saveCurrentFragment();
        $this->currentFragment = $name;
    }

    public function moveToDefaultFragment()
    {
        $this->moveToFragment(self::DEFAULT_FRAGMENT);
    }

    public function getFragment($fragment, $default = "")
    {
        if (!isset($this->fragmentContents[$fragment])) {
            return $default;
        }
        return $this->fragmentContents[$fragment];
    }

    public function setVariable($varname, $value)
    {
        $this->variables[$varname] = $value;
    }

    public function getVariable($varname, $default = NULL)
    {
        if (!isset($this->variables[$varname])) {
            return $default;
        }
        return $this->variables[$varname];
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($controller, $viewname)
    {
        include(__DIR__ . "/../view/$controller/$viewname.php");
        $this->renderLayout();
    }

    public function redirect($controller, $action, $queryString = NULL)
    {
        header("Location: index.php?controller=$controller&action=$action" . (isset($queryString) ? "&$queryString" : ""));
        die();
    }

    private function renderLayout()
    {
        $this->moveToFragment("layout");
        include(__DIR__ . "/../view/layouts/" . $this->layout . ".php");
        ob_flush();
    }

    private static $viewmanager_singleton = NULL;
    public static function getInstance()
    {
        if (self::$viewmanager_singleton == null) {
            self::$viewmanager_singleton = new ViewManager();
        }
        return self::$viewmanager_singleton;
    }
}

ViewManager::getInstance();
