@csrf
@isset($manufacturer) @method('PUT') @endisset

<div class="space-y-5 max-w-lg">
    <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $manufacturer->name ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
        {{ isset($manufacturer) ? 'Update Manufacturer' : 'Create Manufacturer' }}
    </button>
</div>
