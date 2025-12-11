<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerStoreController extends Controller
{
    private function sellerStore()
    {
        return Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->first();
    }

    public function edit()
    {
        $store = $this->sellerStore();

        if (!$store) {
            return redirect()->route('buyer.store.create')
                ->with('error', 'Toko belum tersedia atau belum diverifikasi.');
        }

        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);

        $store = $this->sellerStore();

        if (!$store) {
            return redirect()->route('buyer.store.create')
                ->with('error', 'Toko tidak ditemukan.');
        }

        $data = $request->only(['name', 'description', 'address', 'phone']);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }

            $data['logo'] = $request->file('logo')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()->route('seller.store.edit')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }
}
