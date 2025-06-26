<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([      // Laravel default
             'name' => 'Test User',
             'email' => 'test@example.com',
             'is_admin' => true
         ]);

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test2@example.com',
         ]);

        \App\Models\Listing::factory(10)->create([
            'by_user_id' => 1           // Because it is a non-nullable field
        ]);

        \App\Models\Listing::factory(10)->create([
            'by_user_id' => 2           // Because it is a non-nullable field
        ]);
    }
}
