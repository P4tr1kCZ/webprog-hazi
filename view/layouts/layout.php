<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentuser");

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $view->getVariable("title", "no title") ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

            <a class="navbar-brand" href="/">Kitalált Kft.</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($currentuser)) : ?>
                        <li class="nav-item"><span class="nav-link" style="color: black;"><?= sprintf("Hello %s", $currentuser) ?></span></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">Menu</a>
                            <ul id="dropdownlist" class="dropdown-menu dropdown-menu-right">
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=users&amp;action=login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=users&amp;action=register">Register</a></li>
                    <?php endif ?>
                </ul>

            </div>
        </nav>
    </header>

    <main class="container">
        <div id="flash">
            <?= $view->popFlash() ?>
        </div>

        <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>

    <footer>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dropdown.js"></script>
</body>

</html>