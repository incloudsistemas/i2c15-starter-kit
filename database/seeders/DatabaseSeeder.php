<?php

namespace Database\Seeders;

use Database\Seeders\System\RolesAndPermissionsSeeder;
use Database\Seeders\System\UsersSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
