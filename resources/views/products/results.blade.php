@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <h1 class="text-2xl font-bold mb-6">
        Search Results
        @if (request('search'))
            <span class="text-slate-400 font-normal text-lg">for "{{ request('search') }}"</span>
        @endif
    </h1>

    @if ($products->isEmpty())
        <p class="text-slate-500">No products found matching your criteria.</p>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                @include('products._card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
@endsection
