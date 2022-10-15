@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('all-products.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.all_products.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.all_products.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $products->image ? \Storage::url($products->image) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_products.inputs.name')</h5>
                    <span>{{ $products->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_products.inputs.subcategory_id')</h5>
                    <span
                        >{{ optional($products->subcategory)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('all-products.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Products::class)
                <a
                    href="{{ route('all-products.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
