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

    public function show($id)
    {
        $store = Store::withTrashed()
            ->with(['user', 'products' => fn($q) => $q->latest()->take(10)])
            ->withCount(['products', 'transactions'])
            ->findOrFail($id);

        return view('admin.stores.show', compact('store'));
    }

    public function create()
    {
        $users = User::where('role', 'member')->get();
        return view('admin.stores.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'name'         => 'required|string|max:255',
            'address'      => 'required|string',
            'about'        => 'nullable|string', // kolom ini WAJIB ada
            'phone'        => 'nullable|string',
            'city'         => 'nullable|string',
            'address_id'   => 'nullable|numeric',
            'postal_code'  => 'nullable|string|max:10',
        ]);

        Store::create([
            'user_id'     => $request->user_id,
            'name'        => $request->name,
            'address'     => $request->address,
            'about'       => $request->about ?? '-',  // default agar tidak error
            'phone'       => $request->phone,
            'city'        => $request->city,
            'address_id'  => $request->address_id ?? 0,
            'postal_code' => $request->postal_code ?? '00000',
            'is_verified' => false,
        ]);

        return redirect()->route('admin.stores.index')
                         ->with('success', 'Toko berhasil dibuat.');
    }

    public function edit($id)
    {
        $store = Store::withTrashed()->findOrFail($id);
        $users = User::where('role', 'member')->get();

        return view('admin.stores.edit', compact('store', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'name'         => 'required|string|max:255',
            'address'      => 'required|string',
            'about'        => 'nullable|string',
            'phone'        => 'nullable|string',
            'city'         => 'nullable|string',
            'address_id'   => 'nullable|numeric',
            'postal_code'  => 'nullable|string|max:10',
        ]);

        $store = Store::withTrashed()->findOrFail($id);

        $store->update([
            'user_id'     => $request->user_id,
            'name'        => $request->name,
            'address'     => $request->address,
            'about'       => $request->about ?? '-',
            'phone'       => $request->phone,
            'city'        => $request->city,
            'address_id'  => $request->address_id ?? 0,
            'postal_code' => $request->postal_code ?? '00000',
        ]);

        return redirect()->route('admin.stores.show', $store->id)
                         ->with('success', 'Toko berhasil diperbarui.');
    }

    public function verify($id)
    {
        $store = Store::findOrFail($id);

        if ($store->is_verified) {
            return back()->with('info', 'Toko sudah terverifikasi.');
        }

        $store->update(['is_verified' => true]);

        return redirect()
            ->route('admin.stores.show', $store->id)
            ->with('success', 'Toko berhasil diverifikasi.');
    }

    public function reject($id)
    {
        $store = Store::findOrFail($id);

        if ($store->is_verified) {
            return back()->with('error', 'Toko yang sudah terverifikasi tidak bisa ditolak.');
        }

        $store->delete();

        return redirect()
            ->route('admin.stores.index')
            ->with('success', 'Pengajuan toko ditolak.');
    }

    public function destroy($id)
    {
        $store = Store::withTrashed()->findOrFail($id);

        if (!$store->trashed()) {
            $store->delete();
            return redirect()->route('admin.stores.index')
                ->with('success', 'Toko berhasil dihapus.');
        }

        $store->forceDelete();
        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko berhasil dihapus permanen.');
    }

    public function restore($id)
    {
        $store = Store::onlyTrashed()->findOrFail($id);
        $store->restore();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko berhasil dipulihkan.');
    }
}