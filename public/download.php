<?php

require_once '../src/config/config.php';
require_once CONTROLLER_PATH . 'DocumentController.php';
require_once CONTROLLER_PATH . 'TimeBytimeController.php';
require_once SERVER_PATH . 'DB.php';

$docID = isset($_GET['docID']) ? intval($_GET['docID']) : 0;
$docID_timebytime = isset($_GET['docID_timebytime']) ? intval($_GET['docID_timebytime']) : 0;

if ($docID > 0) {
    $db = new DB();
    $controller = new DocumentController($db);
    $controller->downloadDocument($docID);
}elseif ($docID_timebytime > 0) {
    $db = new DB();
    $TimeByTimeController = new TimeBytimeController($db);
    $TimeByTimeController->downloadDocument($docID_timebytime);
}
 else {
    Session::set('download_error', 'ID de documento no válido.');
} 
