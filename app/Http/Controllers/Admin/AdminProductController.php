<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Tampilkan semua produk
     */
    public function index()
    {
        $products = Product::with('store', 'user')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Hapus produk berdasarkan ID
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan!');
        }

        // Hapus foto jika ada
        if ($product->image && file_exists(public_path('storage/' . $product->image))) {
            unlink(public_path('storage/' . $product->image));
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }
}
