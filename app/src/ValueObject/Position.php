<?php
declare(strict_types=1);

namespace Kata\ValueObject;

class Position
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function samePosition(Position $otherPosition): bool
    {
        return $this->getX() === $otherPosition->getX() && $this->getY() === $otherPosition->getY();
    }
}