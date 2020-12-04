<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "SOAP");
$errors = $view->getVariable("errors");
?>

<div class="row">
    <h1>SOAP</h1>
</div>