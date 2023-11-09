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
    public SchemeValidator $SchemeValidator;
    public ProductValidator $ProductValidator;
    public CSVHandler $CSVHandler;

    public function __construct(SchemeValidator $SchemeValidator, ProductValidator $ProductValidator, CSVHandler $CSVHandler)
    {
        $this->SchemeValidator = $SchemeValidator;
        $this->ProductValidator = $ProductValidator;
        $this->CSVHandler = $CSVHandler;
    }

    public function addProduct(): array 
    {
        $product = new Product();
        if (!$this->SchemeValidator->isProductSchemeValid($_POST)) {
            $message = 'Invalid product structure';
            $responseCode = 400;
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        $product = $product->createFromData($_POST);
        $response = $this->ProductValidator->validateProduct($product);
        if ($response['success'] == 'true') {
            $responseCode = 201;
            $this->CSVHandler->addProductToTable((array)$product);
        }
        return [$response, $responseCode];
    }

    public function getAllProducts(): array  
    {
        $response = $this->CSVHandler->getProductsArray();
        $responseCode = 200;
        return [$response, $responseCode];
    }

    public function getProductByID(): array  
    {
        if (!$this->CSVHandler->productExists($_POST['code'])) {
            $message = 'Product doesn\'t exist';
            $responseCode = 404;
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        $response = $this->CSVHandler->getProductById($_POST['code']);
        $responseCode = 200;
        return [$response, $responseCode];
    }

    public function deleteProductByID(): array
    {
        if (!$this->CSVHandler->productExists($_POST['code'])) {
            $message = 'Product doesn\'t exist';
            $responseCode = 404;
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        $response = [
            'success' => 'true'
        ];
        $responseCode = 200;
        return [$response, $responseCode];
    }

    public function udateProductByID($id): array 
    {
        if (!$this->CSVHandler->productExists($_POST['code'])) {
            $message = 'Product doesn\'t exist';
            $responseCode = 404;
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        $response = [
            'success' => 'true'
        ];
        $responseCode = 200;
        return [$response, $responseCode];
    }

    public function getMyProducts(): array
    {
        $response = $this->CSVHandler->getMyProducts($_POST['user_id']);
        $responseCode = 200;
        return [$response, $responseCode];
    }
}