<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomType = RoomType::factory()
                                ->count(2)
                                ->state(new Sequence(
                                    ['type'  => 'single'],
                                    ['type'  => 'double'],
                                    ['has_internal_bathroom' => 1],
                                    ['has_internal_bathroom', 0],
                                ))
                                ->create();
    }
}
