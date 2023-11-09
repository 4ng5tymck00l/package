<?php

namespace App\Service\Validator;
use App\Models\Product;
use App\Service\Validator\SchemeValidator;
use App\Exception\CustomException;
use App\Service\DataHandlers\ErrorHandler;

class ProductValidator
{   
    private const MAX_CODE = 10;
    private const MAX_SUP = 3;
    private const MAX_FLOAT = 2;
    private const MAX_NAME = 64;
    private const MIN_NAME = 5;
    private const MAX_DESC = 300;
    
    private const CODE_TEMPLATE = '/^(\d{1,3})-(\d{1,})$/';

    public function isProductCodeValid(Product $product): bool 
    {
        $code = $product->code;
        if (empty($code) || !preg_match(self::CODE_TEMPLATE, $code)) {
            return false;
        }
        if (strlen($code) > self::MAX_CODE) {
            return false;
        }

        return true;
    }

    public function isProductPriceValid(Product $product): bool 
    {
        $price = $product->price;
        if (empty($price)) {
            return false;
        }
        $priceDevided = explode('.', $price);
        if (count($priceDevided) != 2 || strlen($priceDevided[1]) != self::MAX_FLOAT) {
            return false;
        }
    
        return true;
    }

    public function isProductNameValid(Product $product): bool 
    {
        $name = $product->name;
        if (empty($name)) {
            return false;
        }
        if (strlen($name) < self::MIN_NAME || strlen($name) > self::MAX_NAME) {
            return false;
        }
    
        return true;
    }

    public function isProductDescriptionValid(Product $product): bool 
    {
        $description = $product->description;
        if (empty($description)) {
            return false;
        }
        if (strlen($description) > self::MAX_DESC) {
            return false;
        }

        return true;
    }

    public function validateProduct(Product $product): array 
    {
        if (!$this->isProductCodeValid($product)) {
            $responseCode = 400;
            $message = 'Invalid product code';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        if (!$this->isProductPriceValid($product)) {
            $responseCode = 400;
            $message = 'Invalid product price';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        if (!$this->isProductNameValid($product)) {
            $responseCode = 400;
            $message = 'Invalid product name';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }
        if (!$this->isProductDescriptionValid($product)) {
            $responseCode = 400;
            $message = 'Invalid product description';
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->logError($message);
            throw new CustomException($message, $responseCode);
        }

        $response = ['success' => true];
        return $response;
    }

}