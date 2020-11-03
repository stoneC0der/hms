<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = Booking::factory()->count(15)->state(new Sequence(
            ['duration' => 1],
            ['duration' => 2],
            ['duration' => 3],
            ['duration' => 4],
            ['duration' => 5],
            ['duration' => 6],
        ))->create();
    }
}
