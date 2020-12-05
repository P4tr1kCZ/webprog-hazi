<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$posts = $view->getVariable("posts");
$view->setVariable("title", "Posts");
?>



<div class="row" style="justify-content: space-between; align-items:center;">
    <h1>Posts</h1>
    <?php if (isset($_SESSION["currentuser"])) : ?>
        <form method="POST" action="index.php?controller=posts&amp;action=add">
            <button type="submit" class="btn btn-primary">Create post</button>
        </form>
    <?php endif; ?>
    <?php if (count($posts) == 0) : ?>
        <div class="col-12" style="text-align: center;"><em>Nincsenek megjeleníthető bejegyzések.</em></div>
    <?php endif; ?>
    <?php foreach ($posts as $post) : ?>
        <div class="card col-12" style="padding: 0;">
            <div class="card-header">
                <div class="row" style="justify-content: space-between;">
                    <div>
                        <?php
                        if (isset($_SESSION["currentuser"]) && isset($_SESSION["role"]) && ($_SESSION["currentuser"] == $post->getAuthor()->getUsername() || $_SESSION["role"] == "ADMIN")) : ?>
                            <form method="POST" action="index.php?controller=posts&amp;action=delete" id="delete_post_<?= $post->getId(); ?>" style="display: inline">
                                <input type="hidden" name="id" value="<?= $post->getId() ?>">
                                <a href="index.php?controller=posts&amp;action=edit&amp;id=<?= $post->getId() ?>">Edit</a>
                                <a href="#" onclick="if (confirm('<?= "are you sure?" ?>')) {
                                    document.getElementById('delete_post_<?= $post->getId() ?>').submit()}">
                                    Delete
                                </a>
                            </form>
                            &nbsp;
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><a href="index.php?controller=posts&amp;action=view&amp;id=<?= $post->getId() ?>"><?= htmlentities($post->getTitle()) ?></a></h5>
                    <em><?= sprintf("by %s at %s", $post->getAuthor()->getUsername(), $post->getCreated()) ?></em>
                    <textarea class="form-control" name="content" rows="2" readonly><?= $post->getContent() ?></textarea>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>