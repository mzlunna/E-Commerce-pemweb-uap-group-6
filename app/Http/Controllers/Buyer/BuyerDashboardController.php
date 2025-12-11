<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        // Get categories with product count
        $categories = ProductCategory::withCount('products')->get();

        // Get featured products with relations
        $products = Product::with(['images', 'store', 'category'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('buyer.dashboard', compact('categories', 'products'));
    }
}