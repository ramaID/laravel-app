<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ImportSahamLamaCommandTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_can_success_import_data()
    {
        $this->artisan('app:import-saham-lama-command')
            ->expectsOutput('Starting')
            ->assertSuccessful();

        $this->assertDatabaseCount('old_stocks', 1);
    }
}
