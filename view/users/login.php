<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<h1>Login</h1>
<?= isset($errors["general"]) ? $errors["general"] : "" ?>

<form action="index.php?controller=users&amp;action=login" method="POST">
    Username: <input type="text" name="username">
    Password: <input type="password" name="password">
    <input type="submit" value="Login">
</form>

<p>Not user?<a href="index.php?controller=users&amp;action=register">Register here!</a></p>
<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" type="text/css" src="css/style2.css">
<?php $view->moveToDefaultFragment(); ?>