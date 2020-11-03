<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room = Room::factory()->count(20)->state(new Sequence(
            ['is_available' => true],
            ['is_available' => false],
        ))->create();
    }
}
