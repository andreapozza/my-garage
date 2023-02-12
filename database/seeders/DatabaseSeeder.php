<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Garage;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            VoyagerDatabaseSeeder::class,
            GarageSeeder::class,
            VehicleSeeder::class,
        ]);
            
        if ( ! User::exists()) {
            \App\Models\User::factory()->admin()->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com'
            ]);
        }

        Garage::create([
            'name' => 'Test',
            'user_id' => 1
        ]);

    }
}
