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
        $query = Product::with(['images', 'category', 'store', 'reviews'])
            ->inStock();

        // Filter by category
        if ($request->category) {
            $query->where('product_category_id', $request->category);
        }

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Price range
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'popular':
                $query->withCount('transactionDetails')
                      ->orderBy('transaction_details_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString(); // ← TAMBAH INI biar filter tetap di URL
        $categories = ProductCategory::withCount('products')->get();

        return view('buyer.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'category', 'store', 'reviews.transaction.buyer.user'])
            ->findOrFail($id);

        // Related products from same store
        $relatedProducts = Product::with(['images'])
            ->where('store_id', $product->store_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->take(4)
            ->get();

        return view('buyer.products.show', compact('product', 'relatedProducts'));
    }
}