<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "REST");
$errors = $view->getVariable("errors");
?>

<div class="container">
    <h1>REST Users list</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody id="userstable">
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label for="exampleFormControlTextarea1">Result in JSON</label>
            <textarea id="jsonresult" class="form-control" id="exampleFormControlTextarea1" rows="20" readonly></textarea>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="js/example_rest.js"></script>