<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(2)->state(new Sequence(
            ['phone'    => '0572345623'],
            ['phone'    => '0575261829'],
        ))->create();
        $this->call([
            RoomTypesSeeder::class,
            RoomsSeeder::class,
            TenantsSeeder::class,
            RentsSeeder::class,
        ]);
    }
}
