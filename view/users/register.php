<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>

<div class="container">
    <div class="row d-flex" style="justify-content: center;">
        <div class="col-4">
            <h1 style="text-align: center;">Register</h1>
            <form action="index.php?controller=users&amp;action=register" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" type="text" name="username" value="<?= $user->getUsername() ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" id="password" type="password" name="password" value="" required>
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <p style="margin-top: 20px;">Already registered?&nbsp;<a href="index.php?controller=users&amp;action=login">Login here!</a></p>
                </div>
            </form>
            <?= isset($errors["general"]) ? $errors["general"] : "" ?>
        </div>
    </div>
</div>