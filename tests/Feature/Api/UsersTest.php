<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use LazilyRefreshDatabase;
    use WithFaker;

    public function test_it_returns_an_user_as_a_resource_object()
    {
        $user = User::factory()->create();

        $this->getJson('api/v1/users/'.$user->id)
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
                    ],
                ],
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

    public function test_it_returns_an_user_as_a_resource_object_by_name()
    {
        $user = User::factory()->create();

        $this->getJson('api/v1/users/by-name/'.$user->name)
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
                    ],
                ],
            ]);
    }

    public function test_it_can_create_an_user_from_a_resource_object()
    {
        $userName = $this->faker->userName();
        $email = $this->faker->email();
        $attributes = ['name' => $userName, 'email' => $email, 'password' => 'secret'];

        $this->postJson('api/v1/users', $attributes)
            ->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $this->assertUserResourceJson($json);
            })
            ->assertHeader('Location', url('api/v1/users/1'));

        $this->assertDatabaseHas('users', ['name' => $userName, 'email' => $email]);
    }

    public function test_it_can_update_an_user_from_a_resource_object()
    {
        $user = User::factory()->create();
        $name = $this->faker->userName();
        $email = $this->faker->email();
        $attributes = ['name' => $name, 'email' => $email];

        $this->patchJson('api/v1/users/1', $attributes)
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $this->assertUserResourceJson($json);
            });

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => $name, 'email' => $email]);
    }

    private function assertUserResourceJson(AssertableJson $json): void
    {
        $json->has('data', 3)
            ->has('data', function (AssertableJson $json) {
                $json->has('id')
                    ->has('type')
                    ->has('attributes', 4)
                    ->has('attributes', function (AssertableJson $json) {
                        $json->has('name')
                            ->has('email')
                            ->has('created_at')
                            ->has('updated_at');
                    })
                    ->whereAllType([
                        'id' => 'integer',
                        'type' => 'string',
                        'attributes' => 'array',
                    ]);
            });
    }
}
