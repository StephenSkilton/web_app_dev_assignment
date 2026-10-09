@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                <option value="customer" @selected(old('role', $user->role) === 'customer')>Customer</option>
                <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
            </select>
            @if ($user->id === auth()->id())
                <input type="hidden" name="role" value="{{ $user->role }}">
                <p class="text-xs text-slate-400 mt-1">You can't change your own role.</p>
            @endif
            @error('role') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
            Update User
        </button>
    </form>
@endsection
