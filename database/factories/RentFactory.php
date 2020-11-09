<?php

namespace Database\Factories;

use App\Models\Rent;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id'   => $this->isRoomAvailable(),
            'tenant_id' => Tenant::select('id')->get()->random()->id,
            'duration'  => 2,
            'from'      => $this->faker->dateTime('2020, 4, 21, 12'),
            'to'        => $this->faker->dateTime('now'),
            'currency'  => $this->faker->currencyCode,
            'amount'    => (RoomType::select('type')->get()->random()->type == 'single') ? '300' : '250',
            'balance'    => $this->faker->numberBetween(50, 200),
        ];
    }

    public function isRoomAvailable() 
    {
        $room = Room::select('id','room_type_id', 'is_available')->get()->random();

        if ($room->is_available) {
            if (RoomType::find($room->room_type_id)->type == 'single') {
                $room->is_available = boolval(true);
                return $room->id;
            }else {
                if (Rent::find($room->id)) {
                    $room->is_available = boolval(true);
                    return $room->id;
                }
                return $room->id;
            }
        }
        return $room->id;
    }
}
