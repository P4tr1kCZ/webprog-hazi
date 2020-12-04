<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "REST");
$errors = $view->getVariable("errors");
?>

<div class="container">
    <h1>Drawings</h1>
    <div class="row">
        <div class="col-12" style="display: flex;">
            <canvas id="canvas" width="500" height="500"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <input type="color" id="circle" name="circle">
            <label for="head">Circle</label>
        </div>
        <div class="col-6">
            <input type="color" id="rectangle" name="rectangle">
            <label for="head">Rectangle</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <button type="button" id="circlebtn" name="circlebtn">Add Circle</button>
        </div>
        <div class="col-6">
            <button type="button" id="rectanglebtn" name="rectanglebtn">Add Rectangle</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="js/draw.js"></script>