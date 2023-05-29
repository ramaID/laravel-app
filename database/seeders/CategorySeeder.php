<?php

namespace Database\Seeders;

use Domain\Content\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 50; $i++) {
            $data[] = Category::factory()->make()->toArray();
        }
        foreach (array_chunk($data, 25) as $chunk) {
            Category::query()->insert($chunk);
        }
    }
}
