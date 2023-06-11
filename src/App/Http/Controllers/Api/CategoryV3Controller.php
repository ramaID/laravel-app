<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Content\Data\CategoryData;
use Domain\Content\Models\Category;
use Domain\Content\Services\SearchCategoryService;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

/**
 * @group Category management V3
 * APIs for managing categories
 */
class CategoryV3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[QueryParam(name: 'query', required: false, example: 'lor')]
    #[QueryParam(name: 'take', required: false, type: 'number', description: 'Default: 15, ', example: 5)]
    #[QueryParam(name: 'order_by', required: false, description: 'Default: latest by created_at, ')]
    #[QueryParam(name: 'order_direction', required: false, description: 'Default: descending, ')]
    public function index(Request $request)
    {
        $service = new SearchCategoryService($request->all());

        return CategoryData::collection($service->search());
    }

     /**
      * Store a newly created resource in storage.
      */
     #[BodyParam(name: 'name')]
     #[BodyParam(name: 'description', required: false)]
    public function store(Request $request)
    {
        $attributes = $request->toArray();

        return CategoryData::from(Category::query()->create($attributes));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return CategoryData::from($category);
    }

    /**
     * Update the specified resource in storage.
     */
    #[BodyParam(name: 'name')]
    #[BodyParam(name: 'description', required: false)]
    public function update(CategoryData $request, Category $category)
    {
        $category->update($request->toArray());

        return CategoryData::from($category->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, 204);
    }
}
