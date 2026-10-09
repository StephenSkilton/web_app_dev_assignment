<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('manufacturer')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $manufacturers = Manufacturer::all();

        return view('admin.products.create', compact('manufacturers'));
    }

public function store(Request $request)
{
    
    // The key here must be 'image' to match your input name attribute
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:255|unique:products,sku',
        'price' => 'required|numeric|min:0|max:999999.99',
        'manufacturer_id' => 'required|exists:manufacturers,id',
        'image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
        'description' =>'nullable|string|max:255'
    ]);

    if ($request->hasFile('image')) {
        $validated['product_image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Product created.');
}
    public function edit(Product $product)
    {
        $manufacturers = Manufacturer::all();

        return view('admin.products.edit', compact('product', 'manufacturers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,'.$product->id,
            'price' => 'required|numeric|min:0|max:999999.99',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048', // 1. Validate image
        ]);

        // 2. Handle image replacement
        if ($request->hasFile('image')) {
            // Delete the old file if it exists to save disk space
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            
            // Store the new file
            $validated['product_image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        // Delete physical file from storage upon record deletion
        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
