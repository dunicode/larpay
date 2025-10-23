<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Currency::create([
            'name' => 'Dollar',
            'slug' => '$',
        ]);

        Currency::create([
            'name' => 'Euro',
            'slug' => '€',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@local.dev',
            'password' => bcrypt('asd123..'),
        ]);
    }
}
