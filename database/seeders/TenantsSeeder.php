<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = Tenant::factory()->count(15)->state(new Sequence(
            ['occupation'   => 'student'],
            ['occupation'   => 'worker'],
            ['phone'    => '0572345623'],
            ['phone'    => '0575261829'],
        ))->create();
    }
}
