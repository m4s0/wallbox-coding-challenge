<?php
declare(strict_types=1);

namespace Kata\Tests\Model;

use Kata\Enum\DirectionsEnum;
use Kata\Model\City;
use Kata\Model\Vehicle;
use Kata\ValueObject\Position;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    protected City $city;

    protected function setUp(): void
    {
        parent::setUp();
        $this->city = new City(5, 5);
    }

    /** @test  */
    public function it_should_initialise_a_vehicle(): void
    {
        $position = new Position(1, 2);
        $vehicle = new Vehicle($position, DirectionsEnum::NORTH, $this->city);

        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::NORTH, $vehicle->getDirection());
    }

    /** @test  */
    public function it_should_spin_90_degrees_right_a_vehicle(): void
    {
        $position = new Position(1, 2);
        $vehicle = new Vehicle($position, DirectionsEnum::NORTH, $this->city);

        $vehicle->spinRight();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::EAST, $vehicle->getDirection());

        $vehicle->spinRight();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::SOUTH, $vehicle->getDirection());

        $vehicle->spinRight();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::WEST, $vehicle->getDirection());

        $vehicle->spinRight();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::NORTH, $vehicle->getDirection());
    }

    /** @test  */
    public function it_should_spin_90_degrees_left_a_vehicle(): void
    {
        $position = new Position(1, 2);
        $vehicle = new Vehicle($position, DirectionsEnum::NORTH, $this->city);

        $vehicle->spinLeft();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::WEST, $vehicle->getDirection());

        $vehicle->spinLeft();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::SOUTH, $vehicle->getDirection());

        $vehicle->spinLeft();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::EAST, $vehicle->getDirection());

        $vehicle->spinLeft();
        self::assertTrue($vehicle->getPosition()->samePosition($position));
        self::assertEquals(DirectionsEnum::NORTH, $vehicle->getDirection());
    }

    /** @test  */
    public function it_should_move_forward_a_vehicle(): void
    {
        $position = new Position(1, 2);
        $vehicle = new Vehicle($position, DirectionsEnum::NORTH, $this->city);

        $vehicle->move();
        $newPosition = new Position(1, 3);
        self::assertTrue($vehicle->getPosition()->samePosition($newPosition));
        self::assertEquals(DirectionsEnum::NORTH, $vehicle->getDirection());
    }
}
