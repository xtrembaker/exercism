<?php

declare(strict_types=1);

function isIsogram(string $word): bool
{
    preg_match_all('/(\w)(?=.*?\1)/iu', $word, $matches);

    return empty($matches[0]);
}