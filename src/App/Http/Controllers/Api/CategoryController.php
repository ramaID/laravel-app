<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use Domain\Content\Models\Category;
use Domain\Content\Resources\CategoryResource;
use Domain\Content\Services\SearchCategoryService;
use Illuminate\Http\Request;

/**
 * @group Category management
 * APIs for managing categories
 */
class CategoryController extends Controller
{
    /**
     * Listing
     */
    public function index(Request $request)
    {
        $service = new SearchCategoryService($request->all());

        return CategoryResource::collection($service->search());
    }

    /**
     * Storing
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::query()->create($request->toArray());

        return (new CategoryResource($category))
            ->response()
            ->header('Location', route('category.show', $category));
    }

    /**
     * Showing
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Updating
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $category->update($request->toArray());

        return (new CategoryResource($category))->response();
    }

    /**
     * Deleting
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, 204);
    }
}
