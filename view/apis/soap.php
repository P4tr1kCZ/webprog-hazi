<?php

require_once(__DIR__ . "/../../utils/ViewManager.php");

include_once(__DIR__ . "/../../soap/client.php");

$view = ViewManager::getInstance();
$view->setVariable("title", "SOAP");
$errors = $view->getVariable("errors");

$user = $client->getName(array('username' => $_SESSION["currentuser"]));
$xml = simplexml_load_string($user);
?>

<div class="container">
    <div class="row" style="margin-top: 50px;">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <div class="card" style="display:flex;">
                <div class="card-body">
                    <h1 class="card-title" style="text-align: center;">SOAP Profile</h5>
                        <h2 class="card-subtitle mb-2 text-muted">User: <?= $_SESSION["currentuser"] ?> </h2>
                        <p class="card-text">Use can see your profile data in this page.</p>
                        <form>
                            <fieldset disabled>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" class="form-control" value="<?= $xml->username ?>">
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" id="role" class="form-control" value="<?= $xml->role ?>">
                                </div>
                            </fieldset>
                        </form>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label for="exampleFormControlTextarea1">Result in XML</label>
            <textarea id="jsonresult" class="form-control" id="exampleFormControlTextarea1" rows="20" readonly><?= $user ?></textarea>
        </div>
    </div>
</div>

<?php
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
} ?>