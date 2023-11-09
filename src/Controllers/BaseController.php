<?php

namespace App\Controllers;
use App\Service\DataHandlers\ErrorHandler;
use App\Exception\CustomException;

class BaseController
{
    public function view($data = []): void
    {
        $filename = '../src/Views/response/main.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            $message = 'View not found';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
    }
}