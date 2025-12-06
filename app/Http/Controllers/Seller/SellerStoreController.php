<?php

namespace App\Http\Controllers\Seller;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerStoreController extends Controller
{
    // Menampilkan form pengajuan toko
    public function create()
    {
        return view('seller.apply-store'); // Halaman untuk pengajuan toko
    }

    // Menyimpan pengajuan toko
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        // Menyimpan toko dengan status 'pending' sampai disetujui admin
        Store::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'pending', // Status toko 'pending' sampai disetujui
        ]);

        return redirect()->route('buyer.home')->with('success', 'Toko berhasil diajukan!');
    }
}
