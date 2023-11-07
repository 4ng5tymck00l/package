<?php

namespace App\Service\Validator;

class SchemeValidator
{
    public function isProductSchemeValid(array $productData): bool 
    {
        $required = array('code','price','name','description');
        $missing = array_diff_key(array_flip($required), $productData);
        $extra = array_diff_key($productData, array_flip($required));
        if (!empty($missing) || !empty($extra)) {
            return false;
        }
        return true;
    }

}