<?php

require_once 'global.php';

function responseJSON($data) {
    die(json_encode($data));
}


$action = $_GET['action'] ?? 'index';

if ($action == 'index') {
    die('API is live');
}

if ($action === 'updateProfile') {
    $controller = new AuthController()
    $controller->login();
}
