<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('manufacturer')->get();

        return view('products.index', compact('products'));
    }
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:100',
        ]);

        // 1. Start the query
        $query = Product::with('manufacturer');

        // 2. Apply filters if they exist in the request
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        // 3. Paginate and append the request data to the pagination links
        $products = $query->paginate(10)->appends($request->all());

        // 4. Return your separate results view
        return view('products.results', compact('products'));
    }
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
