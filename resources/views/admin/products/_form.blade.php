@if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- ONE SINGLE FORM TAG WRAPPING EVERYTHING -->
<form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @isset($product) 
        @method('PUT') 
    @endisset

    <div class="space-y-5 max-w-lg">
        <!-- 1. Text Fields -->
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

         <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <input type="text" name="description" value="{{ old('description', $product->description ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Manufacturer</label>
            <select name="manufacturer_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select a manufacturer</option>
                @foreach ($manufacturers as $manufacturer)
                    <option value="{{ $manufacturer->id }}" @selected(old('manufacturer_id', $product->manufacturer_id ?? '') == $manufacturer->id)>{{ $manufacturer->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- 2. The File Field (No extra form tags around this!) -->
        <div>
            <label class="block text-sm font-medium mb-1">Product Image</label>
            <input type="file" name="image" id="image" class="w-full text-sm text-slate-500">
        </div>

        <!-- 3. Submit Button -->
        <div class="pt-2">
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
                {{ isset($product) ? 'Update Product' : 'Create Product' }}
            </button>
        </div>
    </div>

</form>