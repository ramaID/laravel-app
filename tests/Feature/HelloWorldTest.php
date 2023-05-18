<?php

namespace Tests\Feature;

use Tests\TestCase;

class HelloWorldTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/hello');

        $response->assertStatus(200)->assertSee('World');
    }
}
