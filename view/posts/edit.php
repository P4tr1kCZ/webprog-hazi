<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$post = $view->getVariable("post");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Post");

?>

<div class="container">
    <div class="row d-flex" style="justify-content: center;">
        <div class="col-4">
            <h1 style="text-align: center;">Modify post</h1>
            <form action="index.php?controller=posts&amp;action=edit" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" type="text" name="title" value="<?= isset($_POST["title"]) ? $_POST["title"] : $post->getTitle() ?>">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="10"><?= isset($_POST["content"]) ? htmlentities($_POST["content"]) : htmlentities($post->getContent()) ?></textarea>
                </div>
                <div style="text-align: center;">
                    <input type="hidden" name="id" value="<?= $post->getId() ?>">
                    <input class="btn btn-primary" type="submit" name="submit" value="Modify post">
                </div>
            </form>
            <?= isset($errors["title"]) ? $errors["title"] : "" ?><br>
            <?= isset($errors["content"]) ? $errors["content"] : "" ?><br>
            <?= isset($errors["general"]) ? $errors["general"] : "" ?>
        </div>
    </div>
</div>