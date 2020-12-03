<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $view->getVariable("title", "no title") ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
</head>

<body>
    <header>
        <h1>News</h1>
        <nav id="menu" style="background-color:grey">
            <ul>
                <li><a href="index.php?controller=posts&amp;action=index">Posts</a></li>

                <?php if (isset($currentuser)) : ?>
                    <li><?= sprintf("Hello %s", $currentuser) ?>
                        <a href="index.php?controller=users&amp;action=logout">(Logout)</a>
                    </li>

                <?php else : ?>
                    <li><a href="index.php?controller=users&amp;action=login">Login</a></li>
                <?php endif ?>
            </ul>
        </nav>
    </header>

    <main>
        <div id="flash">
            <?= $view->popFlash() ?>
        </div>

        <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>

    <footer>
    </footer>

</body>

</html>