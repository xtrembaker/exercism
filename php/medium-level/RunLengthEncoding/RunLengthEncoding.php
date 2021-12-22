<?php

declare(strict_types=1);

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

function encode(string $input): string
{
    return preg_replace_callback('/(.)\1*/', 'encode_match', $input);
}

function decode(string $input): string
{
    return preg_replace_callback('/(\d+)?(.)/', 'decode_match', $input);
}

function encode_match(array $match): string
{
    $n = strlen($match[0]);
    return $n > 1 ? $n . $match[1] : $match[1];
}

function decode_match(array $match): string
{
    return str_repeat($match[2], intval($match[1]) ?: 1);
};