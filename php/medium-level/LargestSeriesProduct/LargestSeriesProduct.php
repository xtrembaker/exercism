<?php

declare(strict_types=1);

class LargestSeriesProduct
{
    public function __construct(
        private string $digits
    )
    {
        if (preg_match('/\D/', $this->digits))
            throw new InvalidArgumentException('Digits input must only contain digits');
    }

    public function largestProduct(int $span): int
    {
        $digitsLength = strlen($this->digits);
        if($span < 0 || $span > $digitsLength){
            throw new InvalidArgumentException();
        }
        if($span === 0){
            return 1;
        }

        $largestProduct = 0;
        for($offset=0;($offset + $span) <= $digitsLength;$offset++){
            $digits = str_split(substr($this->digits, $offset, $span));
            $product = array_product($digits);
            if($product > $largestProduct){
                $largestProduct = $product;
            }
        }
        return $largestProduct;
    }
}