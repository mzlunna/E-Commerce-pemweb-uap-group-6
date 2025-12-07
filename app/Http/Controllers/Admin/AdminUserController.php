<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users with their stores.
     */
    public function index(Request $request)
    {
        // Don't eager load store to avoid foreign key issues
        $query = User::latest();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(20);
        
        // Manually load store for each user to handle missing relationship
        $users->each(function($user) {
            try {
                $user->load('store');
            } catch (\Exception $e) {
                // Ignore if relationship fails
            }
        });

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user with store details.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Load store relationship
        $user->load('store');
        
        // Only load store details if user has a store
        if ($user->store) {
            $user->store->loadCount('products')
                        ->load('storeBalance');
        }

        return view('admin.users.index', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|in:admin,member',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user->id)
                       ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $isSelf = $user->id === auth()->id();

        // If deleting self, redirect to confirmation page
        if ($isSelf) {
            return redirect()->route('admin.users.confirmDelete', $user->id);
        }

        // Delete user
        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Show password confirmation page before self-delete.
     */
    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);

        // Only allow self-delete confirmation
        if ($user->id !== auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Anda tidak dapat mengakses halaman ini.');
        }

        return view('admin.users.confirm-delete', compact('user'));
    }

    /**
     * Process self-delete with password confirmation.
     */
    public function destroySelf(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Ensure it's the authenticated user
        if ($user->id !== auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Unauthorized action.');
        }

        // Validate password and confirmation
        $request->validate([
            'password' => 'required|string',
            'confirmation' => 'required|in:DELETE',
        ], [
            'confirmation.in' => 'Ketik "DELETE" untuk konfirmasi penghapusan akun.',
        ]);

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        // Delete user and logout
        $userName = $user->name;
        $user->delete();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                       ->with('success', "Akun {$userName} berhasil dihapus. Silakan login kembali jika ingin membuat akun baru.");
    }
}