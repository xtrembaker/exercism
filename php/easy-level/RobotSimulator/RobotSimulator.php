<?php

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

declare(strict_types=1);

class Robot
{
    public const
        DIRECTION_NORTH = [0, 1],
        DIRECTION_EAST = [1, 0],
        DIRECTION_SOUTH = [0, -1],
        DIRECTION_WEST = [-1, 0];

    public array $position, $direction;

    public function __construct(array $position, array $direction)
    {
        assert(count($position) == 2);
        $this->position = $position;
        $this->direction = $direction;
    }

    public function turnRight(): Robot
    {
        [$x, $y] = $this->direction;
        $this->direction = [$y, -$x];
        return $this;
    }

    public function turnLeft(): Robot
    {
        [$x, $y] = $this->direction;
        $this->direction = [-$y, $x];
        return $this;
    }

    public function advance(): Robot
    {
        $this->position[0] += $this->direction[0];
        $this->position[1] += $this->direction[1];
        return $this;
    }

    public function instructions(string $steps): Robot
    {
        if (!preg_match('/^[LRA]*$/', $steps)) {
            throw new InvalidArgumentException('Instruction set must only contains L, R or A.');
        }
        foreach (str_split($steps) as $step) {
            match ($step) {
                'R' => $this->turnRight(),
                'L' => $this->turnLeft(),
                'A' => $this->advance()
            };
        }
        return $this;
    }
}