<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$post = $view->getVariable("post");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Post");

?>

<h1>Modify post</h1>
<form action="index.php?controller=posts&amp;action=edit" method="POST">
    Title: <input type="text" name="title" value="<?= isset($_POST["title"]) ? $_POST["title"] : $post->getTitle() ?>">
    <?= isset($errors["title"]) ? $errors["title"] : "" ?><br>

    Contents: <br>
    <textarea name="content" rows="4" cols="50">
        <?= isset($_POST["content"]) ?
            htmlentities($_POST["content"]) :
            htmlentities($post->getContent())
        ?>
    </textarea>
    <?= isset($errors["content"]) ? $errors["content"] : "" ?><br>

    <input type="hidden" name="id" value="<?= $post->getId() ?>">
    <input type="submit" name="submit" value="Modify post">
</form>