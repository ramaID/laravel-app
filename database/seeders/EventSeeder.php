<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 100_000; $i++) {
            $event = Event::factory()->make();
            $data[] = $event->toArray();
        }
        /**
         * reducing the number calls to the insert() method for multiple rows to insert with an
         * array as an argument is much faster the execution than calling insert() every single row
         */
        foreach (array_chunk($data, 100) as $chunk) {
            Event::query()->insert($chunk);
        }
    }
}
