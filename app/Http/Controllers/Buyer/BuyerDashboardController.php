<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'images'])
            ->where('stock', '>', 0);

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('product_categories.id', $request->category);
            });
        }

        // Filter by price
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $products = $query->latest()->paginate(12);
        $categories = ProductCategory::all();

        return view('buyer.dashboard', compact('products', 'categories'));
    }
}