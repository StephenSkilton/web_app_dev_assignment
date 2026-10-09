@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ __('Profile') }}</h1>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white border border-slate-200 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white border border-slate-200 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white border border-slate-200 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
