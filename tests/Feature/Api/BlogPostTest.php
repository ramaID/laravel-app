<?php

namespace Tests\Feature\Api;

use Domain\Content\Models\BlogPost;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    use LazilyRefreshDatabase;
    use WithFaker;

    public function testItReturnsABlogPostAsAResourceObject()
    {
        /** @var BlogPost $blog */
        $blog = BlogPost::factory()->create();

        $this->getJson('api/v1/blog-post/'.$blog->slug)
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json->has('included')
                    ->has('jsonapi', 2)
                    ->has('data', 6)
                    ->has('data', function (AssertableJson $json) {
                        $this->assertableBlogPostResource($json);
                    });
            });
    }

    public function testItReturnsBlogPostAsACollectionOfResourceObjects()
    {
        BlogPost::factory()->count(36)->create();

        $firstBlog = BlogPost::query()->first();

        $this->getJson('api/v1/blog-post')
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $this->assertableBlogPostPaginate($json, 15);
            });

        $this->getJson('api/v1/blog-post?'.http_build_query(['search' => $firstBlog->title]))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $this->assertableBlogPostPaginate($json, 1);
            });
    }

    private function assertableBlogPostResource(AssertableJson $json)
    {
        $json->has('id')
            ->has('type')
            ->has('attributes', 7)
            ->whereType('id', 'string')
            ->whereType('type', 'string')
            ->whereType('attributes', 'array')
            ->has('attributes', function (AssertableJson $json) {
                $json
                    ->has('title')
                    ->has('slug')
                    ->has('author')
                    ->has('date')
                    ->has('likes')
                    ->has('status')
                    ->has('body')
                    ->whereAllType([
                        'title' => 'string',
                        'slug' => 'string',
                        'author' => 'string',
                        'date' => 'string',
                        'likes' => 'integer',
                        'status' => 'string',
                        'body' => 'string',
                    ]);
            })
            ->etc();
    }

    private function assertableBlogPostPaginate(AssertableJson $json, int $count)
    {
        $json->has('data', $count)
            ->has('data.0', function (AssertableJson $json) {
                $this->assertableBlogPostResource($json);
            })
            ->has('links', function (AssertableJson $json) {
                $json->whereAllType([
                    'first' => 'string',
                    'last' => 'string',
                ])->etc();
            })
            ->has('meta', 8)
            ->has('meta', function (AssertableJson $json) {
                $json
                    ->whereAllType([
                        'current_page' => 'integer',
                        'from' => 'integer',
                        'last_page' => 'integer',
                        'links' => 'array',
                        'path' => 'string',
                        'per_page' => 'integer',
                        'to' => 'integer',
                        'total' => 'integer',
                    ])
                    ->has('links.0', function (AssertableJson $json) {
                        $json->whereAllType([
                            'url' => 'string|null',
                            'label' => 'string',
                            'active' => 'boolean',
                        ]);
                    });
            })
            ->etc();
    }
}
