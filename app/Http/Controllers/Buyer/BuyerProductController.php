<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class BuyerProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'images'])->where('stock', '>', 0);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('product_categories.id', $request->category);
            });
        }

        $products = $query->paginate(12);
        $categories = ProductCategory::all();
        
        return view('buyer.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['store', 'categories', 'images', 'reviews.user'])
            ->findOrFail($id);
        
        $relatedProducts = Product::where('store_id', $product->store_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(4)
            ->get();
        
        return view('buyer.products.show', compact('product', 'relatedProducts'));
    }
}