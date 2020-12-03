<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$post = $view->getVariable("post");
$currentuser = $view->getVariable("currentusername");
$newcomment = $view->getVariable("comment");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View Post");

?><h1><?= "Post" . ": " . htmlentities($post->getTitle()) ?></h1>
<em><?= sprintf("by %s", $post->getAuthor()->getUsername()) ?></em>
<p>
    <?= htmlentities($post->getContent()) ?>
</p>

<h2>Comments</h2>

<?php foreach ($post->getComments() as $comment) : ?>
    <hr>
    <p><?= sprintf("%s commented...", $comment->getAuthor()->getUsername()) ?> </p>
    <p><?= $comment->getContent(); ?></p>
<?php endforeach; ?>

<?php if (isset($currentuser)) : ?>
    <h3>Write a comment</h3>

    <form method="POST" action="index.php?controller=comments&amp;action=add">
        Comment:<br>
        <?= isset($errors["content"]) ? $errors["content"] : "" ?><br>
        <textarea type="text" name="content">
            <?= htmlentities($newcomment->getContent()); ?>
        </textarea>
        <input type="hidden" name="id" value="<?= $post->getId() ?>"><br>
        <input type="submit" name="submit" value="do comment">
    </form>

<?php endif ?>