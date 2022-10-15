<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Requests\SubcategoryStoreRequest;
use App\Http\Requests\SubcategoryUpdateRequest;

class SubcategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Subcategory::class);

        $search = $request->get('search', '');

        $subcategories = Subcategory::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.subcategories.index',
            compact('subcategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Subcategory::class);

        $categories = Category::pluck('name', 'id');

        return view('app.subcategories.create', compact('categories'));
    }

    /**
     * @param \App\Http\Requests\SubcategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryStoreRequest $request)
    {
        $this->authorize('create', Subcategory::class);

        $validated = $request->validated();

        $subcategory = Subcategory::create($validated);

        return redirect()
            ->route('subcategories.edit', $subcategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Subcategory $subcategory)
    {
        $this->authorize('view', $subcategory);

        return view('app.subcategories.show', compact('subcategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Subcategory $subcategory)
    {
        $this->authorize('update', $subcategory);

        $categories = Category::pluck('name', 'id');

        return view(
            'app.subcategories.edit',
            compact('subcategory', 'categories')
        );
    }

    /**
     * @param \App\Http\Requests\SubcategoryUpdateRequest $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        SubcategoryUpdateRequest $request,
        Subcategory $subcategory
    ) {
        $this->authorize('update', $subcategory);

        $validated = $request->validated();

        $subcategory->update($validated);

        return redirect()
            ->route('subcategories.edit', $subcategory)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subcategory $subcategory)
    {
        $this->authorize('delete', $subcategory);

        $subcategory->delete();

        return redirect()
            ->route('subcategories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
