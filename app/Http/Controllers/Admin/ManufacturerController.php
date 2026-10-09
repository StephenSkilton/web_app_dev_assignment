<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::withCount('products')->with('products')->get();

        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Manufacturer::create($validated);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer created.');
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $manufacturer->update($validated);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer updated.');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer deleted.');
    }
}
