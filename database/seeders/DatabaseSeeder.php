<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('Admin@123'),
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'testtwo@gmail.com',
            'password' => bcrypt('Admin@123'),
        ]);

        Project::factory()
            ->count(30)
            ->hasTasks(30)->create();
    }
}
