<?php

try {
    require_once(dirname(__FILE__) . "/URIDispatcher.php");
    $files_in_script_dir = scandir(__DIR__);
    foreach ($files_in_script_dir as $filename) {
        if (preg_match('/.*REST\\.PHP/', strtoupper($filename))) {
            include_once(__DIR__ . "/" . $filename);
        }
    }

    $dispatcher = URIDispatcher::getInstance();

    $dispatcher->enableCORS('*', 'origin, content-type, accept, authorization');

    $dispatched = $dispatcher->dispatchRequest();

    if (!$dispatched) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad request');
        die("no dispatcher found for this request");
    }
} catch (Throwable $ex) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal server error');
    header("Content-Type: application/json");
    die(json_encode(array("error" => $ex->getMessage())));
}
