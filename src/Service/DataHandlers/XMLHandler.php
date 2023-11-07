<?php

namespace App\Service\DataHandlers;
use \App\Models\Product;

define('PATH_XML', '../files/product.xml');

class XMLController
{
    public function fileToProduct(): Product 
    {
        $file = file_get_contents(PATH_XML); 
        $simpleXML = simplexml_load_string($file);
        $json = json_encode($simpleXML);
        $productData = json_decode($json, true); 
        $product = new Product();
        $product = $product->productFromData($productData);

        return $product;
    }

}