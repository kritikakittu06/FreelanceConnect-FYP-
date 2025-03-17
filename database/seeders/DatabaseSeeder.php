<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         User::factory()->create([
              'name'  => 'admin',
              'email' => 'admin@example.com',
              'role'  => UserRole::ADMIN,
         ]);
         User::factory()->create([
             'name'  => 'Client',
             'email' => 'client@example.com',
             'role'  => UserRole::CLIENT,
        ]);

         User::factory()->freelancer()->withRandomSkills()->create([
              'name'  => 'freelancer',
              'email' => 'freelancer@example.com',
              'role'  => UserRole::FREELANCER,
         ]);
         User::factory()->freelancer()->withRandomSkills()->count(50)->create();
    }
}
