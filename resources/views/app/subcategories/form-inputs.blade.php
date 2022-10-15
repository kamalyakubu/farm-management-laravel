@php $editing = isset($subcategory) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="category_id" label="Category" required>
            @php $selected = old('category_id', ($editing ? $subcategory->category_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Category</option>
            @foreach($categories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $subcategory->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
