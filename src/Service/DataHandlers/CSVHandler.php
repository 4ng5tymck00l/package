<?php

namespace App\Service\DataHandlers;
use \App\Models\Product;

define('PATH_CSV', '../files/product.csv');

class CSVHandler
{
    public function getProductsArray(): array 
    {
        $lines = file(PATH_CSV, FILE_IGNORE_NEW_LINES);
        $keys = explode(',', $lines[0]);
        $limit = count($keys);
    
        for ($i = 1; !empty($lines[$i]); $i++) {
            $values = explode(',', $lines[$i], $limit);
            for ($j = 0; $j < $limit; $j++) {
                $productData[$keys[$j]] = $values[$j];
            }
            $products[] = $productData;
            
        }
        return $products;
    }

    public function getProductById($id): array 
    {
        $productGenerator = $this->fileToProductArrayGenerator();

        foreach ($productGenerator as $product) {
            if ($product['code'] == $id) {
                return $product;
            } 
        }
    }

    public function getMyProducts($user_id): array 
    {
        $productGenerator = $this->fileToProductArrayGenerator();
        foreach ($productGenerator as $product) {
            if ($product['user_id'] == $user_id) {
              $products[] = $product;
            } 
        }
        return $products;
    }

    public function addProductToTable($product) 
    {
        $handle = fopen(PATH_CSV, "a");
        fputcsv($handle, $product);
        fclose($handle);
    }

    public function fileToProduct(): Product 
    {
        
        $file = file(PATH_CSV);
    
        foreach ($file as $key => $value) {
            $cell=explode(',', $value);
            $productData[$cell[0]]=$cell[1];
        }
        $product = new Product();
        $product = $product->productFromData($productData);

        return $product;
    }

    public function fileToProductArrayGenerator(): \Generator 
    {

        $lines = file(PATH_CSV, FILE_IGNORE_NEW_LINES);
        $keys = explode(',', $lines[0]);
        $limit = count($keys);

        for ($i = 1; !empty($lines[$i]); $i++) {
            $values = explode(',', $lines[$i], $limit);
            for ($j = 0; $j < $limit; $j++) {
                $productData[$keys[$j]] = $values[$j];
            }
            yield $productData;
        }
    }

    public function productExists($id): bool 
    {
        $productGenerator = $this->fileToProductArrayGenerator();

        foreach ($productGenerator as $product) {
            if ($product['code'] == $id) {
                return true;
            } 
        }
        return false;
    }

}