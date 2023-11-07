<?php

namespace App\Controllers;

class BaseController
{
    public function view($data = []) 
    {
        $filename = '../src/Views/response/index.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            echo 'view not found';
        }
    }
}