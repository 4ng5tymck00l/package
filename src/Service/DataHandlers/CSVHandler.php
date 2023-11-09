<?php

namespace App\Service\DataHandlers;
use \App\Models\Product;

class CSVHandler
{
    private const PATH_CSV = '../files/product.csv';

    public function getProductsArray(): array 
    {
        $lines = file(self::PATH_CSV, FILE_IGNORE_NEW_LINES);
        $keys = explode(',', $lines[0]);
        $limit = count($keys);
        $products = [];
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

    public function addProductToTable($product): void
    {
        $handle = fopen(self::PATH_CSV, "a");
        fputcsv($handle, $product);
        fclose($handle);
    }

    public function fileToProductArrayGenerator(): \Generator 
    {

        $lines = file(self::PATH_CSV, FILE_IGNORE_NEW_LINES);
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