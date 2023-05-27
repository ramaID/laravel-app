<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $passwordEnc = Hash::make(fake()->password());
        for ($i = 0; $i < 1_000; $i++) {
            $factory = User::factory()->make();
            $data[] = $factory->toArray() + ['password' => $passwordEnc];
        }
        /**
         * reducing the number calls to the insert() method for multiple rows to insert with an
         * array as an argument is much faster the execution than calling insert() every single row
         */
        foreach (array_chunk($data, 100) as $chunk) {
            User::query()->insert($chunk);
        }
    }
}
