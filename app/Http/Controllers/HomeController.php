<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['store', 'images'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(12)
            ->get();
        
        $categories = ProductCategory::all();
        
        return view('welcome', compact('products', 'categories'));
    }
}