<?php

namespace App\Http\Controllers\Api;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ProductsCollection;

class SubcategoryAllProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Subcategory $subcategory)
    {
        $this->authorize('view', $subcategory);

        $search = $request->get('search', '');

        $allProducts = $subcategory
            ->allProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductsCollection($allProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subcategory $subcategory)
    {
        $this->authorize('create', Products::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'name' => ['required', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $products = $subcategory->allProducts()->create($validated);

        return new ProductsResource($products);
    }
}
