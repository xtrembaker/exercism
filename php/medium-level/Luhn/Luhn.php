<?php

declare(strict_types=1);

function isValid(string $number): bool
{
    $number = str_replace(' ', '', $number);
    $isValidNumber = preg_match('/^[0-9]+$/', $number);
    if(strlen($number) <= 1 || $isValidNumber === 0){
        return false;
    }
    $newNumberReversed = array_map(function($singleNumber, $index){
        if($index % 2 === 0){
            return $singleNumber;
        }
        $newSingleNumber = $singleNumber * 2;
        return $newSingleNumber > 9 ? $newSingleNumber - 9 : $newSingleNumber;
    }, array_reverse(str_split($number)), array_keys(str_split($number)));
    $sum = array_sum($newNumberReversed);
    return ($sum % 10 === 0);
}