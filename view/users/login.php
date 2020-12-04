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
            <form id="idForm" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" type="text" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" id="password" type="password" name="password">
                </div>
                <div style="text-align: center;">
                    <button type="button" onclick="myFunction()" class="btn btn-primary">Login</button>
                    <p style="margin-top: 20px;">Not user?&nbsp;<a href="index.php?controller=users&amp;action=register">Register here!</a></p>
                </div>
            </form>
            <?= isset($errors["general"]) ? $errors["general"] : "" ?>
        </div>
    </div>
</div>

<script>
    function myFunction() {
        console.log($("#username").val());
        console.log($("#password").val());
        $.ajax({
            method: "POST",
            url: "../../controller/UsersController/login",
            data: {
                username: $("#username").val(),
                password: $("#password").val()
            },
            success: function() {},
            error: function() {}
        })
    }
</script>