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
    public const DIRECTION_NORTH = 'north';
    public const DIRECTION_EAST = 'east';
    public const DIRECTION_SOUTH = 'south';
    public const DIRECTION_WEST = 'west';

    private array $directions = [
        self::DIRECTION_NORTH,
        self::DIRECTION_EAST,
        self::DIRECTION_SOUTH,
        self::DIRECTION_WEST
    ];
    /**
     *
     * @var int[]
     */
    public array $position;

    /**
     *
     * @var string
     */
    public $direction;

    public function __construct(array $position, string $direction)
    {
        $this->position = $position;
        $this->direction = $direction;
        while($direction !== current($this->directions)){
            next($this->directions);
        }
    }

    public function turnRight(): self
    {
        if(next($this->directions) === false) reset($this->directions);
        $this->direction = current($this->directions);
        return $this;
    }

    public function turnLeft(): self
    {
        if(prev($this->directions) === false) end($this->directions);
        $this->direction = current($this->directions);
        return $this;
    }

    public function advance(): self
    {
        $position = Position::createFromArray($this->position);
        $this->position = $position->moveForward($this->direction)->toArray();
        return $this;
    }

    public function instructions(string $instructions): void
    {
        foreach(str_split($instructions) as $instruction){
            try {
                match ($instruction) {
                    'R' => $this->turnRight(),
                    'L' => $this->turnLeft(),
                    'A' => $this->advance()
                };
            }catch (UnhandledMatchError){
                throw new InvalidArgumentException($instruction);
            }
        }
    }
}

class Position{

    private function __construct(
        private int $x,
        private int $y,
    )
    {
    }

    public static function createFromArray(array $position): self
    {
        return new Position($position[0], $position[1]);
    }


    public function moveForward($direction): self
    {
        return match($direction){
            'north' => new Position($this->x, $this->y + 1),
            'east' => new Position($this->x + 1, $this->y),
            'south' => new Position($this->x, $this->y - 1),
            'west' => new Position($this->x - 1, $this->y),
        };
    }

    public function toArray(): array
    {
        return [$this->x, $this->y];
    }
}