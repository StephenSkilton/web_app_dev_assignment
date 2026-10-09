@extends('layouts.app')
@section('title', 'New User')
@section('content')
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5 max-w-lg">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="customer" @selected(old('role') === 'customer')>Customer</option>
                <option value="admin" @selected(old('role') === 'admin')>Admin</option>
            </select>
            @error('role') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
            Create User
        </button>
    </form>
@endsection
