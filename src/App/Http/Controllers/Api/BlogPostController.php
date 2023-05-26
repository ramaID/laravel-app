<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Content\Models\BlogPost;
use Domain\Content\Resources\BlogPostResource;
use Domain\Content\Services\SearchBlogPostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\JsonApiResourceCollection;

final class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonApiResourceCollection
    {
        $service = new SearchBlogPostService($request->all());

        return BlogPostResource::collection($service->search());
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost): JsonApiResource
    {
        return BlogPostResource::make($blogPost);
    }
}
