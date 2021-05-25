<?php
declare(strict_types=1);

namespace Kata\Model;

use Kata\Enum\MoveEnum;
use Kata\ValueObject\Position;

class City
{
    private int $upperRightXCoordinates;

    private int $upperRightYCoordinates;

    /**
     * @param array<Vehicle> $vehicles
     */
    private array $vehicles;

    public function __construct(int $upperRightXCoordinates, int $upperRightYCoordinates)
    {
        $this->upperRightXCoordinates = $upperRightXCoordinates;
        $this->upperRightYCoordinates = $upperRightYCoordinates;
        $this->vehicles = [];
    }

    public function getUpperRightXCoordinates(): int
    {
        return $this->upperRightXCoordinates;
    }

    public function getUpperRightYCoordinates(): int
    {
        return $this->upperRightYCoordinates;
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        if (!$vehicle instanceof Vehicle) {
            throw new \LogicException('Expected instance of Vehicle');
        }

        if (!$this->canBeAdded($vehicle)) {
            throw new \LogicException('Vehicle cannot be added to this city');
        }

        $this->vehicles[] = $vehicle;
    }

    /**
     * @return array<Vehicle>
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function canBeAdded(Vehicle $newVehicle): bool
    {
        foreach ($this->getVehicles() as $vehicle) {
            if ($vehicle->getPosition()->samePosition($newVehicle->getPosition())) {
                return false;
            }
        }

        return true;
    }

    public function moveVehicleTo(Vehicle $vehicle, string $to): void
    {
        MoveEnum::throwIfDoesNotContainValue($to);

        if (MoveEnum::RIGHT === $to){
            $vehicle->spinRight();
            return;
        }

        if (MoveEnum::LEFT === $to){
            $vehicle->spinLeft();
            return;
        }

        $nextPosition = $vehicle->getNextPosition();
        if (!$this->containsPosition($nextPosition)){
            return;
        }

        foreach ($this->getVehicles() as $v) {
            if ($v->getPosition()->samePosition($nextPosition)) {
                return;
            }
        }

        $vehicle->move();
    }

    private function containsPosition(Position $nextPosition): bool
    {
        $x = $nextPosition->getX();
        $y = $nextPosition->getY();

        return $x >= 0 && $y >= 0 && $x <= $this->getUpperRightXCoordinates() && $y <= $this->getUpperRightYCoordinates();
    }
}