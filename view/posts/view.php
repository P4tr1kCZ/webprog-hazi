<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$post = $view->getVariable("post");
$currentuser = $view->getVariable("currentuser");
$newcomment = $view->getVariable("comment");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View Post");

?>


<div class="container" style="margin-top: 50px;">
    <div class="card col-12" style="padding: 0;">
        <div class="card-header">
            <div class="row" style="justify-content: space-between;">
                <div>
                    <h3><?= "Title" . ": " . htmlentities($post->getTitle()) ?></h3>
                    <em><?= sprintf("by %s at %s", $post->getAuthor()->getUsername(), $post->getCreated()) ?></em>
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
                        <div class="col-3 col-sm-2 col-md-2 col-lg-2 col-xl-2" style="margin-top: 20px;"><?= sprintf("%s:", $comment->getAuthor()->getUsername()) ?></div>
                        <div class="col-9 col-sm-10 col-md-10 col-lg-10 col-xl-10 form-group">
                            <textarea class="form-control" name="content" rows="2" readonly><?= $comment->getContent(); ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?= isset($errors["content"]) ? $errors["content"] : "" ?><br>
            </div>
        </div>
    </div>
</div>