@csrf
@isset($order) @method('PUT') @endisset

<div class="space-y-5 max-w-lg">
    <div>
        <label class="block text-sm font-medium mb-1">User</label>
        <select name="user_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select a user</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $order->user_id ?? '') == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Date</label>
        <input type="date" name="date" value="{{ old('date', isset($order) ? \Carbon\Carbon::parse($order->date)->format('Y-m-d') : '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        @error('date') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @foreach (['pending', 'processing', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $order->status ?? '') == $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Total</label>
        <input type="number" step="0.01" name="total" value="{{ old('total', $order->total ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        @error('total') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
        {{ isset($order) ? 'Update Order' : 'Create Order' }}
    </button>
</div>
