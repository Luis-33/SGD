<?php

require_once '../src/config/config.php';
require_once CONTROLLER_PATH . 'DocumentController.php';
require_once SERVER_PATH . 'DB.php';

$docID = isset($_GET['docID']) ? intval($_GET['docID']) : 0;

if ($docID > 0) {
    $db = new DB();
    $controller = new DocumentController($db);
    $controller->downloadDocument($docID);
} else {
    Session::set('download_error', 'ID de documento no válido.');
}
