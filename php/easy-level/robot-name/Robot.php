<?php

declare(strict_types=1);

class Robot
{
    private ?string $name = null;

    private static array $names = [];

    public function getName(): string
    {
        return $this->name ?? $this->generateName();
    }

    public function reset(): void
    {
        $this->name = $this->generateName();
    }

    private function generateName(): string
    {
        $alphabet = str_split(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
        do {
            $this->name = $alphabet[mt_rand(0, 25)] .
                $alphabet[mt_rand(0, 25)] .
                mt_rand(0, 9) .
                mt_rand(0, 9) .
                mt_rand(0, 9);
        } while (array_key_exists($this->name, self::$names));
        self::$names[$this->name] = null;
        return $this->name;
    }
}