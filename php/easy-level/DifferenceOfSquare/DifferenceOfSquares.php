<?php

declare(strict_types=1);

function squareOfSum(int $max): int
{
    $result = 0;
    for($number=1;$number<=$max;$number++){
        $result += $number;
    }
    return $result * $result;
}

function sumOfSquares(int $max): int
{
    $result = 0;
    for($number=1;$number<=$max;$number++){
        $result += $number * $number;
    }
    return $result;
}

function difference(int $max): int
{
    return squareOfSum($max) - sumOfSquares($max);
}