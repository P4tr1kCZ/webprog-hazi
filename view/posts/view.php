<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$post = $view->getVariable("post");
$currentuser = $view->getVariable("currentuser");
$newcomment = $view->getVariable("comment");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View Post");

?>

<h1><?= "Post" . ": " . htmlentities($post->getTitle()) ?></h1>
<em><?= sprintf("by %s", $post->getAuthor()->getUsername()) ?></em>
<p>
    <?= htmlentities($post->getContent()) ?>
</p>

<div class="card col-12" style="padding: 0;">
    <div class="card-header">
        <div class="row" style="justify-content: space-between;">
            <div>
                <h3><?= "Title" . ": " . htmlentities($post->getTitle()) ?></h3>
                <em><?= sprintf("by %s", $post->getAuthor()->getUsername()) ?></em>
            </div>
        </div>
        <div class="card-body">
            <textarea class="form-control" name="content" rows="2" readonly><?= $post->getContent() ?></textarea>
        </div>
        <div>
            <?php if (isset($currentuser)) : ?>
                <form method="POST" action="index.php?controller=comments&amp;action=add">
                    Comment:<br>
                    <textarea placeholder="Write a comment..." class="form-control" id="content" name="content" rows="2"><?= htmlentities($newcomment->getContent()); ?></textarea>
                    <input type="hidden" name="id" value="<?= $post->getId() ?>"><br>
                    <input class="btn btn-primary" type="submit" name="submit" value="send comment">
                </form>
            <?php endif ?>
        </div>
        <div>
            <?php foreach ($post->getComments() as $comment) : ?>
                <div class="row" style="align-items:baseline;">
                    <div class="col-1" style="margin-top: 20px;"><?= sprintf("%s:", $comment->getAuthor()->getUsername()) ?></div>
                    <div class="col form-group">
                        <textarea class="form-control" name="content" rows="2" readonly><?= $comment->getContent(); ?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?= isset($errors["content"]) ? $errors["content"] : "" ?><br>
</div>