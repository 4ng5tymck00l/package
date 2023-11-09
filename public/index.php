<?php
use App\Controllers\AppController;
use App\Exception\CustomException;

require_once '../vendor/autoload.php';

$AppStarter = new AppController();
try {
    $response = $AppStarter->initAction();
    $AppStarter->view(compact('response'));
} catch (CustomException $e) {
    $response = [
        '0' => [
            'success' => 'false',
            'error' => $e->getMessage()
        ],
        '1' => $e->getCode()
    ];
    $AppStarter->view(compact('response'));
}
