<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<div class="container">
    <div class="row d-flex" style="justify-content: center;">
        <div class="col-4">
            <h1 style="text-align: center;">Login</h1>
            <form action="index.php?controller=users&amp;action=login" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" type="text" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" id="password" type="password" name="password">
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <p style="margin-top: 20px;">Not user?&nbsp;<a href="index.php?controller=users&amp;action=register">Register here!</a></p>
                </div>
            </form>
            <?= isset($errors["general"]) ? $errors["general"] : "" ?>
        </div>
    </div>
</div>



<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<?php $view->moveToDefaultFragment(); ?>