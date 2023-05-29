<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use Domain\Content\Models\Category;
use App\Http\Controllers\Controller;
use Domain\Content\Data\CategoryData;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;
use Domain\Content\Services\SearchCategoryService;

/**
 * @group Category management V2
 * APIs for managing categories V2
 */
class CategoryController extends Controller
{
    #[QueryParam(name: 'search', required: false, example: 'lor')]
    #[QueryParam(name: 'take', type: 'number', description: 'Default: 15, ', required: false, example: 5)]
    #[QueryParam(name: 'order_by', description: 'Default: latest by created_at, ', required: false)]
    #[QueryParam(name: 'order_direction', description: 'Default: descending, ', required: false)]
    public function index(Request $request)
    {
        $service = new SearchCategoryService($request->all());
        return CategoryData::collection($service->search());
    }

    #[BodyParam(name: 'name')]
    #[BodyParam(name: 'description', required: false)]
    public function store(CategoryData $request)
    {
        $attributes = $request->toArray();
        return CategoryData::from(Category::query()->create($attributes));
    }

    public function show(Category $category)
    {
        return CategoryData::from($category);
    }

    #[BodyParam(name: 'name')]
    #[BodyParam(name: 'description', required: false)]
    public function update(CategoryData $request, Category $category)
    {
        $category->update($request->toArray());

        return CategoryData::from($category->refresh());
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, 204);
    }
}
