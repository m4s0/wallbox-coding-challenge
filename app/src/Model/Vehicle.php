<?php
declare(strict_types=1);

namespace Kata\Model;

use Kata\Enum\DirectionsEnum;
use Kata\ValueObject\Position;

class Vehicle
{
    private Position $position;
    private string $direction;
    private City $city;

    public function __construct(Position $position, string $direction, City $city)
    {
        DirectionsEnum::throwIfDoesNotContainValue($direction);

        $this->position = $position;
        $this->direction = $direction;
        $this->city = $city;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function move(): void
    {
        $this->position = $this->getNextPosition();
    }

    public function getNextPosition(): Position
    {
        if ($this->getDirection() === DirectionsEnum::NORTH){
            return new Position($this->getPosition()->getX(), $this->getPosition()->getY() + 1);
        }

        if ($this->getDirection() === DirectionsEnum::EAST){
            return new Position($this->getPosition()->getX() - 1, $this->getPosition()->getY());
        }

        if ($this->getDirection() === DirectionsEnum::SOUTH){
            return new Position($this->getPosition()->getX(), $this->getPosition()->getY() - 1);
        }

        if ($this->getDirection() === DirectionsEnum::WEST) {
            return new Position($this->getPosition()->getX() + 1, $this->getPosition()->getY());
        }

        return $this->getPosition();
    }

    public function spinRight(): void
    {
        if ($this->getDirection() === DirectionsEnum::NORTH){
            $this->direction = DirectionsEnum::EAST;
            return;
        }

        if ($this->getDirection() === DirectionsEnum::EAST){
            $this->direction = DirectionsEnum::SOUTH;
            return;
        }

        if ($this->getDirection() === DirectionsEnum::SOUTH){
            $this->direction = DirectionsEnum::WEST;
            return;
        }

        if ($this->getDirection() === DirectionsEnum::WEST){
            $this->direction = DirectionsEnum::NORTH;
        }
    }

    public function spinLeft(): void
    {
        if ($this->getDirection() === DirectionsEnum::NORTH){
            $this->direction = DirectionsEnum::WEST;
            return;
        }

        if ($this->getDirection() === DirectionsEnum::WEST){
            $this->direction = DirectionsEnum::SOUTH;
            return;
        }

        if ($this->getDirection() === DirectionsEnum::SOUTH){
            $this->direction = DirectionsEnum::EAST;
            return;
        }

        if ($this->getDirection() === DirectionsEnum::EAST){
            $this->direction = DirectionsEnum::NORTH;
        }
    }
}