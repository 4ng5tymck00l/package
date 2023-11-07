<?php

namespace App\Controllers;

use App\Service\DataHandlers\CSVHandler;
use App\Exception\CustomException;
use App\Service\DataHandlers\ErrorHandler;
use App\Service\Validator\ProductValidator;
use App\Service\Validator\SchemeValidator;
use App\Models\Product;

class ProductController extends BaseController
{
    public function addProduct(): array 
    {
        $product = new Product();
        $SchemeValidator = new SchemeValidator();
        if (!$SchemeValidator->isProductSchemeValid($_POST)) {
            $message = 'Invalid product structure';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
        $product = $product->createFromData($_POST);
        $productValidator = new ProductValidator();
        $response = $productValidator->validateProduct($product);
        if ($response['success'] == 'true') {
            $CSVHandler = new CSVHandler();
            $CSVHandler->addProductToTable((array)$product);
        }
        $this->view(compact('response'));
        return $response;
    }

    public function getAllProducts(): array  
    {
        $CSVHandler = new CSVHandler();
        $response = $CSVHandler->getProductsArray();
        $this->view(compact('response'));
        return $response;
    }

    public function getProductByID(): array  
    {
        $CSVHandler = new CSVHandler();
        if (!$CSVHandler->productExists($_POST['code'])) {
            $message = 'Product doesn\'t exist';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
        $response = $CSVHandler->getProductById($_POST['code']);
        $this->view(compact('response'));
        return $response;
    }

    public function deleteProductByID(): array
    {
        $CSVHandler = new CSVHandler();
        if (!$CSVHandler->productExists($_POST['code'])) {
            $message = 'Product doesn\'t exist';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
        $response = [
            'success' => 'true'
        ];
        $this->view(compact('response'));
        return $response;
    }

    public function udateProductByID($id): array 
    {
        $CSVHandler = new CSVHandler();
        if (!$CSVHandler->productExists($_POST['code'])) {
            $message = 'Product doesn\'t exist';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message);
        }
        $response = [
            'success' => 'true'
        ];
        $this->view(compact('response'));
        return $response;
    }

    public function getMyProducts(): array
    {
        $CSVHandler = new CSVHandler();
        $response = $CSVHandler->getMyProducts($_POST['user_id']);
        $this->view(compact('response'));
        return $response;
    }
}