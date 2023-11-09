<?php

namespace App\Controllers;
use App\Service\DataHandlers\ErrorHandler;
use App\Exception\CustomException;
use App\Service\Validator\ProductValidator;
use App\Service\Validator\SchemeValidator;
use App\Service\DataHandlers\CSVHandler;

class AppController extends BaseController
{
    public function loadController(): string
    {
        $uri = $this->splitURI();
        $filename = '../src/Controllers/' . ucfirst($uri[1]) . 'Controller.php';
        if (file_exists($filename)) {
            require $filename;
            $controllerName = 'App\Controllers\\' . ucfirst($uri[1]) . 'Controller';
        } else {
            $message = 'Invalid URI';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
        return $controllerName;
    }

    public function initAction(): array
    {
        $uri = $this->splitURI();
        $controllerName = $this->loadController();
        $SchemeValidator = new SchemeValidator();
        $ProductValidator = new ProductValidator();
        $CSVHandler = new CSVHandler();
        $controller = new $controllerName($SchemeValidator, $ProductValidator, $CSVHandler);
        if (method_exists($controller, $uri[2])) {
            $action = $uri[2];
            $response = $controller->$action();
            return $response;

        } else {
            $message = 'Invalid or empty method';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
    }

    public function splitURI(): array
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($uri[1])) {
            return $uri;
        }
    }
}