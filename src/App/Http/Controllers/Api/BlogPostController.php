<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Content\Models\BlogPost;
use Domain\Content\Resources\BlogPostResource;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\JsonApiResourceCollection;

final class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonApiResourceCollection
    {
        return BlogPostResource::collection(BlogPost::query()->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost): JsonApiResource
    {
        return BlogPostResource::make($blogPost);
    }
}
