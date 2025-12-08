<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user')
                      ->withCount(['products', 'transactions'])
                      ->latest();

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_verified', false)->whereNull('deleted_at');
            } elseif ($request->status === 'verified') {
                $query->where('is_verified', true)->whereNull('deleted_at');
            } elseif ($request->status === 'deleted') {
                $query->onlyTrashed();
            }
        } else {
            $query->withTrashed();
        }

        $stores = $query->paginate(20);

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.stores.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'city' => 'nullable|string',
            'address_id' => 'nullable|string',
            'address' => 'nullable|string',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $path = $request->hasFile('logo')
            ? $request->file('logo')->store('store_logos', 'public')
            : null;

        $store = Store::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address_id' => $request->address_id ?: '0', // pastikan selalu ada '0' kalau kosong
            'address' => $request->address,
            'about' => $request->about ?? '',
            'logo' => $path,
            'is_verified' => false,
        ]);

        return redirect()->route('admin.stores.show', $store->id)
            ->with('success', 'Store berhasil dibuat dan menunggu verifikasi.');
    }

    public function show($id)
    {
        $store = Store::withTrashed()
            ->with(['user', 'products' => fn($q) => $q->latest()->take(10)])
            ->withCount(['products', 'transactions'])
            ->findOrFail($id);

        return view('admin.stores.show', compact('store'));
    }

    public function edit($id)
    {
        $store = Store::withTrashed()->findOrFail($id);
        $users = User::all();

        return view('admin.stores.edit', compact('store', 'users'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::withTrashed()->findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'city' => 'nullable|string',
            'address_id' => 'nullable|string', // nullable tapi default
            'address' => 'nullable|string',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($store->trashed()) {
            $store->restore();
        }

        $path = $store->logo;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('store_logos', 'public');
        }

        $store->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address_id' => $request->input('address_id', '0'), // default '0'
            'address' => $request->address,
            'about' => $request->about ?? '',
            'logo' => $path,
            'is_verified' => false,
        ]);

        return redirect()->route('admin.stores.show', $store->id)
            ->with('success', 'Store berhasil diupdate dan status kembali PENDING.');
    }

    public function verify($id)
    {
        $store = Store::findOrFail($id);

        if ($store->is_verified) {
            return back()->with('info', 'Toko sudah terverifikasi.');
        }

        $store->update(['is_verified' => true]);

        return redirect()->route('admin.stores.show', $store->id)
            ->with('success', 'Toko berhasil diverifikasi.');
    }

    public function reject($id)
    {
        $store = Store::findOrFail($id);

        if ($store->is_verified) {
            return back()->with('error', 'Toko yang sudah terverifikasi tidak bisa ditolak.');
        }

        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Pengajuan toko ditolak dan dihapus.');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko berhasil dihapus.');
    }

    public function restore($id)
    {
        $store = Store::onlyTrashed()->findOrFail($id);
        $store->restore();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko berhasil dipulihkan.');
    }
}
