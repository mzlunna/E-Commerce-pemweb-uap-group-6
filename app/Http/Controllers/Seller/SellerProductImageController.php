<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerProductImageController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('product_images', 'public');

        $product->images()->create([
            'image' => $path,          // FIX: pakai image
            'is_thumbnail' => 0,
        ]);

        return back()->with('success', 'Image added.');
    }

    public function destroy($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->where('id', $imageId)->firstOrFail();

        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
}
