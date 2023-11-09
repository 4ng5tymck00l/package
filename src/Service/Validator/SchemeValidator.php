<?php

namespace App\Service\Validator;

class SchemeValidator
{
    private const REQUIRED_PARAMS = array('code','price','name','description');

    public function isProductSchemeValid(array $productData): bool 
    {
        $missing = array_diff_key(array_flip(self::REQUIRED_PARAMS), $productData);
        $extra = array_diff_key($productData, array_flip(self::REQUIRED_PARAMS));
        if (!empty($missing) || !empty($extra)) {
            return false;
        }
        return true;
    }

}