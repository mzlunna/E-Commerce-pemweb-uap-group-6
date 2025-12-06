<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreApprovalController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    public function show($id)
    {
        $store = Store::with(['user', 'products'])->findOrFail($id);
        return view('admin.stores.show', compact('store'));
    }

    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['status' => 'approved']);

        return back()->with('success', 'Store approved successfully');
    }

    public function reject(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $store->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Store rejected');
    }
}