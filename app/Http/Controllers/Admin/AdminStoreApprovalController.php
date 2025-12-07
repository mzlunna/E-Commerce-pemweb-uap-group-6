<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreApprovalController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.stores.index', compact('stores'));
    }

    public function show($id)
    {
        $store = Store::with('user')->findOrFail($id);
        return view('admin.stores.show', compact('store'));
    }

    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'approved';
        $store->save();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'rejected';
        $store->rejection_reason = $request->reason;
        $store->save();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko ditolak!');
    }
}