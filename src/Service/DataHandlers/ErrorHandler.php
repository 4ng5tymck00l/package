<?php

namespace App\Service\DataHandlers;

define('PATH_LOG', '../files/appError.log');

class ErrorHandler
{
    public function logError($message)
    {
        $errorData = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
        file_put_contents(PATH_LOG, $errorData, FILE_APPEND);
    }
}