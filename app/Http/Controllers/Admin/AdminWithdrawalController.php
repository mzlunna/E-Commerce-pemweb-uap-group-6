<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalController extends Controller
{
    /**
     * Display a listing of all withdrawal requests.
     */
    public function index(Request $request)
    {
        $query = Withdrawal::with(['storeBalance.store'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Display the specified withdrawal.
     */
    public function show($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->load('storeBalance.store.user');

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Approve a withdrawal request.
     */
    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Hanya penarikan yang berstatus pending yang dapat disetujui.');
        }

        // Wrap in transaction for safety
        DB::transaction(function () use ($withdrawal) {
            $lockedWithdrawal = Withdrawal::where('id', $withdrawal->id)
                                         ->lockForUpdate()
                                         ->first();

            if ($lockedWithdrawal && $lockedWithdrawal->status === 'pending') {
                $lockedWithdrawal->update(['status' => 'approved']);
            }
        });

        return redirect()->route('admin.withdrawals.show', $withdrawal->id)
                       ->with('success', 'Penarikan saldo berhasil disetujui.');
    }

    /**
     * Reject a withdrawal request.
     */
    public function reject($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Hanya penarikan yang berstatus pending yang dapat ditolak.');
        }

        // Refund balance and reject in transaction
        DB::transaction(function () use ($withdrawal) {
            $lockedWithdrawal = Withdrawal::where('id', $withdrawal->id)
                                         ->lockForUpdate()
                                         ->first();

            if ($lockedWithdrawal && $lockedWithdrawal->status === 'pending') {
                $lockedWithdrawal->storeBalance->increment('balance', $lockedWithdrawal->amount);
                $lockedWithdrawal->update(['status' => 'rejected']);
            }
        });

        return redirect()->route('admin.withdrawals.show', $withdrawal->id)
                       ->with('success', 'Penarikan saldo ditolak dan dana telah dikembalikan ke toko.');
    }
}