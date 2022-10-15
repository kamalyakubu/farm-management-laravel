<?php

namespace App\Http\Controllers\Api;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ProductsCollection;
use App\Http\Requests\ProductsStoreRequest;
use App\Http\Requests\ProductsUpdateRequest;

class ProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Products::class);

        $search = $request->get('search', '');

        $allProducts = Products::search($search)
            ->latest()
            ->paginate();

        return new ProductsCollection($allProducts);
    }

    /**
     * @param \App\Http\Requests\ProductsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsStoreRequest $request)
    {
        $this->authorize('create', Products::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $products = Products::create($validated);

        return new ProductsResource($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Products $products)
    {
        $this->authorize('view', $products);

        return new ProductsResource($products);
    }

    /**
     * @param \App\Http\Requests\ProductsUpdateRequest $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsUpdateRequest $request, Products $products)
    {
        $this->authorize('update', $products);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($products->image) {
                Storage::delete($products->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $products->update($validated);

        return new ProductsResource($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Products $products)
    {
        $this->authorize('delete', $products);

        if ($products->image) {
            Storage::delete($products->image);
        }

        $products->delete();

        return response()->noContent();
    }
}
