<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\SubcategoryCollection;

class CategorySubcategoriesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $subcategories = $category
            ->subcategories()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubcategoryCollection($subcategories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', Subcategory::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $subcategory = $category->subcategories()->create($validated);

        return new SubcategoryResource($subcategory);
    }
}
