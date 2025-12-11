<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class SellerCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('seller.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = ProductCategory::parents()->orderBy('name')->get();
        return view('seller.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'parent_id'   => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'tagline'     => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'parent_id', 'description', 'tagline']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_images', 'public');
        }

        ProductCategory::create($data);

        return redirect()->route('seller.category.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        $parents = ProductCategory::parents()
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get();

        return view('seller.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'parent_id'   => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'tagline'     => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'parent_id', 'description', 'tagline']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_images', 'public');
        }

        $category->update($data);

        return redirect()->route('seller.category.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('seller.category.index')
            ->with('success', 'Category deleted.');
    }
}
