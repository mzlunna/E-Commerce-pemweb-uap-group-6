<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = Product::where('store_id', $store->id)->get();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $store = auth()->user()->store;

        // generate slug unik
        $slug = \Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->category,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->desc,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'sold' => 0,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'product_category_id' => $request->category,
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->desc,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
