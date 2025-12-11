<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyerStoreController extends Controller
{
    public function create()
    {
        $existingStore = Store::where('user_id', auth()->id())->first();
        
        if ($existingStore) {
            return redirect()->route('buyer.store.status')
                ->with('info', 'Anda sudah memiliki pengajuan toko');
        }

        return view('buyer.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'about' => 'required|string|min:50',
            'phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required|string',
            'address_id' => 'nullable|string', // Optional
            'city' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $existingStore = Store::where('user_id', auth()->id())->first();
        
        if ($existingStore) {
            return redirect()->route('buyer.store.status')
                ->with('error', 'Anda sudah memiliki pengajuan toko!');
        }

        DB::beginTransaction();
        try {
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('stores/logos', 'public');
            }

            $store = Store::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'logo' => $logoPath ?? 'stores/default-logo.png',
                'about' => $request->about,
                'phone' => $request->phone,
                'address' => $request->address,
                'address_id' => $request->address_id ?? '',
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'is_verified' => 0, // Pending
            ]);

            // Create store balance with 0
            \App\Models\StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0,
            ]);

            DB::commit();

            return redirect()->route('buyer.store.status')
                ->with('success', 'Pengajuan toko berhasil! Silakan tunggu verifikasi admin.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal mengajukan toko: ' . $e->getMessage());
        }
    }

    public function status()
    {
        $store = Store::where('user_id', auth()->id())->first();
        
        if (!$store) {
            return redirect()->route('buyer.store.create');
        }

        return view('buyer.store.status', compact('store'));
    }
}