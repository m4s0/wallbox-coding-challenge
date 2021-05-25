<?php

declare(strict_types = 1);

namespace Kata\Tests\Model;

use Kata\Enum\DirectionsEnum;
use Kata\Enum\MoveEnum;
use Kata\Model\City;
use Kata\Model\Vehicle;
use Kata\ValueObject\Position;
use PHPUnit\Framework\TestCase;

final class CityTest extends TestCase
{
    /** @test  */
    public function it_should_initialise_a_city(): void
    {
        $city = new City(5, 5);

        self::assertEquals(5, $city->getUpperRightXCoordinates());
        self::assertEquals(5, $city->getUpperRightYCoordinates());
    }

    /** @test  */
    public function it_should_add_a_vehicle(): void
    {
        $city = new City(5, 5);
        self::assertCount(0, $city->getVehicles());

        $position = new Position(1, 2);
        $vehicle = new Vehicle($position, DirectionsEnum::NORTH, $city);
        $city->addVehicle($vehicle);
        self::assertCount(1, $city->getVehicles());
    }

    /** @test  */
    public function it_should_throw_an_exception_if_vehicle_cannot_be_added(): void
    {
        $city = new City(5, 5);
        $position = new Position(1, 2);
        $vehicle1 = new Vehicle($position, DirectionsEnum::NORTH, $city);
        $city->addVehicle($vehicle1);
        self::assertCount(1, $city->getVehicles());

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Vehicle cannot be added to this city');
        $vehicle2 = new Vehicle($position, DirectionsEnum::SOUTH, $city);
        $city->addVehicle($vehicle2);
    }

    /** @test  */
    public function it_can_move_a_vehicle_to_a_specific_position(): void
    {
        $city = new City(5, 5);
        $position1 = new Position(1, 1);
        $position2 = new Position(1, 2);
        $vehicle1 = new Vehicle($position1, DirectionsEnum::WEST, $city);
        $vehicle2 = new Vehicle($position2, DirectionsEnum::NORTH, $city);

        $city->addVehicle($vehicle1);
        $city->addVehicle($vehicle2);

        $city->moveVehicleTo($vehicle1, MoveEnum::MOVE_FORWARD);
        $expectedPosition = new Position(2, 1);
        self::assertTrue($vehicle1->getPosition()->samePosition($expectedPosition));
    }

    /** @test  */
    public function it_cannot_move_a_vehicle_to_a_specific_position(): void
    {
        $city = new City(5, 5);
        $position1 = new Position(1, 1);
        $position2 = new Position(1, 2);
        $vehicle1 = new Vehicle($position1, DirectionsEnum::NORTH, $city);
        $vehicle2 = new Vehicle($position2, DirectionsEnum::NORTH, $city);

        $city->addVehicle($vehicle1);
        $city->addVehicle($vehicle2);

        $city->moveVehicleTo($vehicle1, MoveEnum::MOVE_FORWARD);
        self::assertFalse($vehicle1->getPosition()->samePosition($position2));
    }


    /**
     * @test
     * @dataProvider provideInputs
     */
    public function it_should_move_a_vehicle(City $city, array $inputs): void
    {
        foreach ($inputs as $input) {
            $vehicle = $input['vehicle'];
            $city->addVehicle($vehicle);

            foreach ($input['movements'] as $movement) {
                $city->moveVehicleTo($vehicle, $movement);
            }

            self::assertTrue($vehicle->getPosition()->samePosition($input['expectedPosition']), $input['expectedPosition']->getX() . ' ' . $input['expectedPosition']->getY());
            self::assertEquals($input['expectedDirection'], $vehicle->getDirection(), $input['expectedDirection']);
        }
    }

    public function provideInputs(): iterable
    {
        $city = new City(5, 5);

        $vehicle1 = [
            'vehicle' => new Vehicle(new Position(1, 2), DirectionsEnum::NORTH, $city),
            'movements' => ['L', 'M', 'L', 'M', 'L', 'M', 'L', 'M', 'M'],
            'expectedPosition' => new Position(1,3),
            'expectedDirection' => DirectionsEnum::NORTH
        ];

        $vehicle2 =[
            'vehicle' => new Vehicle(new Position(3, 3), DirectionsEnum::EAST, $city),
            'movements' => ['M','M','R','M','M','R','M','R','R','M'],
            'expectedPosition' => new Position(2,1),
            'expectedDirection' => DirectionsEnum::EAST
        ];

        yield 'Test Input' => [
            'city' => $city,
            'inputs' => [
                $vehicle1,
                $vehicle2
            ]
        ];
    }
}
