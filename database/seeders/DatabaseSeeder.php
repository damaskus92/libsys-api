<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory()
            ->hasBooks(3)
            ->create([
                'name' => 'Damas Eka Kusuma',
                'birth_date' => '1992-09-15'
            ]);
    }
}
