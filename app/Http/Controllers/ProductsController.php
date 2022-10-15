<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.all_products.index', compact('allProducts', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Products::class);

        $subcategories = Subcategory::pluck('name', 'id');

        return view('app.all_products.create', compact('subcategories'));
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

        return redirect()
            ->route('all-products.edit', $products)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Products $products)
    {
        $this->authorize('view', $products);

        return view('app.all_products.show', compact('products'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Products $products)
    {
        $this->authorize('update', $products);

        $subcategories = Subcategory::pluck('name', 'id');

        return view(
            'app.all_products.edit',
            compact('products', 'subcategories')
        );
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

        return redirect()
            ->route('all-products.edit', $products)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('all-products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
