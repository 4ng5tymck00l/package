<?php
use App\Controllers\AppController;
use App\Exception\CustomException;

require_once '../vendor/autoload.php';

$AppStarter = new AppController();
try {
    $AppStarter->initAction();
} catch (CustomException $e) {
    $response = [
        'success' => 'false',
        'error' => $e->getMessage()
    ];
    $AppStarter->view(compact('response'));
}
