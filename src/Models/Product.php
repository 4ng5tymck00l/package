<?php

namespace App\Models;

class Product
{   
    public $code;
    public $price;
    public $name;
    public $description;
    public $user_id;

    public function __construct(string $code = '', string $price = '', string $name = '', string $description = '', $user_id = '') {
        $this->code = $code;
        $this->price = $price;
        $this->name = $name;
        $this->description = $description;
        $this->user_id = $user_id;
    }

    public static function createFromData(array $productData): Product {
        $productData = array_map('strip_tags', $productData); 
        $productData = array_map('trim', $productData);
        $product = new self();
        foreach ($productData as $key => $value) {
            $product->$key = $value;
        }
            
        return $product;
    }

}