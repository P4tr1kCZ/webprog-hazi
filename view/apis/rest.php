<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "REST");
$errors = $view->getVariable("errors");
?>

<div class="row">
    <h1>REST</h1>
</div>