<?php

namespace Database\Seeders;

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
        \App\Models\Role::factory(3)->create();
        \App\Models\Address::factory(3)->create();
        \App\Models\User::factory(3)->create();
        \App\Models\User::factory()->userAdmin()->create();
        \App\Models\UserDocument::factory(3)->create();
        \App\Models\Account::factory(1)->create();
        \App\Models\Vehicle::factory(3)->create();
        \App\Models\VehicleDocument::factory(3)->create();
        \App\Models\Journey::factory(3)->create();
        \App\Models\Transaction::factory(3)->create();
        \App\Models\Qualification::factory(2)->create();
    }
}
