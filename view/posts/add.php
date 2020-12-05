<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$post = $view->getVariable("post");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Create Post");

?>

<div class="container">
    <div class="row d-flex" style="justify-content: center;">
        <div class="col-4">
            <h1 style="text-align: center;">Create post</h1>
            <form action="index.php?controller=posts&amp;action=add" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" type="text" name="title">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="10"></textarea>
                </div>
                <div style="text-align: center;">
                    <input class="btn btn-primary" type="submit" name="submit" value="Create Post">
                </div>
            </form>
            <?= isset($errors["general"]) ? $errors["general"] : "" ?>
        </div>
    </div>
</div>