<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();

$posts = $view->getVariable("posts");
$currentUser = $view->getVariable("currentusername");

$view->setVariable("title", "Posts");
?>

<h1>Posts</h1>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($posts as $post) : ?>
        <tr>
            <td>
                <a href="index.php?controller=posts&amp;action=view&amp;id=<?= $post->getId() ?>"><?= htmlentities($post->getTitle()) ?></a>
            </td>
            <td>
                <?= $post->getAuthor()->getUsername() ?>
            </td>
            <td>
                <?php

                if (isset($currentuser) && $currentuser == $post->getAuthor()->getUsername()) : ?>

                    <form method="POST" action="index.php?controller=posts&amp;action=delete" id="delete_post_<?= $post->getId(); ?>" style="display: inline">

                        <input type="hidden" name="id" value="<?= $post->getId() ?>">

                        <a href="#" onclick="
				if (confirm('<?= "are you sure?" ?>')) {
					document.getElementById('delete_post_<?= $post->getId() ?>').submit()
				}">Delete</a>

                    </form>
                    &nbsp;
                    <a href="index.php?controller=posts&amp;action=edit&amp;id=<?= $post->getId() ?>">Edit</a>

                <?php endif; ?>

            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php if (isset($currentuser)) : ?>
    <a href="index.php?controller=posts&amp;action=add">Create post</a>
<?php endif; ?>