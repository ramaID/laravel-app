<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Domain\Content\Models\BlogPost;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Artisan::call('app:import-saham-lama-command');
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            CategorySeeder::class,
            // EventSeeder::class,
        ]);
        BlogPost::factory()->count(10)->create();
    }
}
