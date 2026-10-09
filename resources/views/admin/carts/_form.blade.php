@csrf
@isset($cart) @method('PUT') @endisset

<div class="space-y-5 max-w-lg">
    <div>
        <label class="block text-sm font-medium mb-1">User</label>
        <select name="user_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select a user</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $cart->user_id ?? '') == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
        {{ isset($cart) ? 'Update Cart' : 'Create Cart' }}
    </button>
</div>
