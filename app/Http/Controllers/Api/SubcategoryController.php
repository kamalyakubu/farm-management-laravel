<?php

namespace App\Http\Controllers\Api;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\SubcategoryCollection;
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
            ->paginate();

        return new SubcategoryCollection($subcategories);
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

        return new SubcategoryResource($subcategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subcategory $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Subcategory $subcategory)
    {
        $this->authorize('view', $subcategory);

        return new SubcategoryResource($subcategory);
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

        return new SubcategoryResource($subcategory);
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

        return response()->noContent();
    }
}
