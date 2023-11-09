<?php

namespace App\Service\DataHandlers;

class ErrorHandler
{
    private const PATH_LOG = '../var/log/appError.log';

    public function logError(string $message): void
    {
        $errorData = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
        file_put_contents(self::PATH_LOG, $errorData, FILE_APPEND);
    }
}