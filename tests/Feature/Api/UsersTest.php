<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_returns_an_user_as_a_resource_object()
    {
        $user = User::factory()->create();

        $this->getJson('api/v1/users/' . $user->id)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'type' => 'users',
                    'attributes' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'created_at' => $user->created_at->toJSON(),
                        'updated_at' => $user->updated_at->toJSON(),
                    ]
                ]
            ]);
    }

    public function test_it_returns_all_users_as_a_collection_of_resource_objects()
    {
        User::factory()->count(15)->create();

        $this->get('api/v1/users')
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 10)
                    ->has('data.0', function (AssertableJson $json) {
                        $json->has('id')
                            ->has('type')
                            ->has('attributes', 4)
                            ->whereAllType([
                                'id' => 'integer',
                                'type' => 'string',
                                'attributes' => 'array',
                            ]);
                    })
                    ->has('links', 4)
                    ->has('links', function (AssertableJson $json) {
                        $json->whereAllType([
                            'first' => 'string',
                            'last' => 'string',
                            'prev' => 'null',
                            'next' => 'string',
                        ]);
                    })
                    ->has('meta', 8)
                    ->has('meta', function (AssertableJson $json) {
                        $json->has('links', 4)
                            ->has('links.0', function (AssertableJson $json) {
                                $json->has('url')
                                    ->has('label')
                                    ->has('active')
                                    ->whereAllType([
                                        'url' => 'string|null',
                                        'label' => 'string',
                                        'active' => 'boolean',
                                    ]);
                            })
                            ->whereAllType([
                                'current_page' => 'integer',
                                'from' => 'integer',
                                'last_page' => 'integer',
                                'path' => 'string',
                                'per_page' => 'integer',
                                'to' => 'integer',
                                'total' => 'integer',
                            ]);
                    })
                    ->whereAllType([
                        'data' => 'array',
                        'links' => 'array',
                        'meta' => 'array',
                    ]);
            });
    }
}
