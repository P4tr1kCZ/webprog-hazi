<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>
<h1>Register</h1>
<form action="index.php?controller=users&amp;action=register" method="POST">
    Username: <input type="text" name="username" value="<?= $user->getUsername() ?>">
    <?= isset($errors["username"]) ? $errors["username"] : "" ?><br>

    Password: <input type="password" name="password" value="">
    <?= isset($errors[""]) ? $errors["password"] : "" ?><br>

    <input type="submit" value="<?= "Register" ?>">
</form>