<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel du UserSeeder
        $this->call(UserSeeder::class);


        $this->call([
        RolesAndPermissionsSeeder::class,
    ]);


    }
}
