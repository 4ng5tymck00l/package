<?php

namespace App\Controllers;

class AppController extends BaseController
{
    public function loadController() 
    {
        $uri = $this->splitURI();
        $filename = '../src/Controllers/' . ucfirst($uri[1]) . 'Controller.php';
        if (file_exists($filename)) {
            require $filename;
            $controllerName = 'App\Controllers\\' . ucfirst($uri[1]) . 'Controller';
        } else {
            echo 'controller not found';
            $controllerName = '';
        }
        return $controllerName;
    }

    public function initAction() 
    {
        $uri = $this->splitURI();
        $controllerName = $this->loadController();
        $controller = new $controllerName;
        if (!empty($uri[2])) {
            call_user_func_array([$controller, $uri[2]], []);
        }
    }

    function splitURI(): array
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($uri[1])) {
            return $uri;
        }
    }
}