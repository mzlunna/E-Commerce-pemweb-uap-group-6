<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(20);

        $users->each(function ($user) {
            try {
                $user->load('store');
            } catch (\Exception $e) {}
        });

        return view('admin.users.index', compact('users'));
    }

        public function show($id)
    {
        $user = User::findOrFail($id);

        // Load relasi store
        $user->load('store');

        // Ambil store (bisa null)
        $store = $user->store;

        // Jika store ada, load tambahan
        if ($store) {
            $store->loadCount('products')
                ->load('storeBalance');
        }

        return view('admin.users.show', compact('user', 'store'));
    }


        public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role'  => 'sometimes|in:admin,member',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user->id)
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $isSelf = $user->id === auth()->id();

        if ($isSelf) {
            return redirect()->route('admin.users.confirmDelete', $user->id);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat mengakses halaman ini.');
        }

        return view('admin.users.confirm-delete', compact('user'));
    }

    public function destroySelf(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'password'     => 'required|string',
            'confirmation' => 'required|in:DELETE',
        ], [
            'confirmation.in' => 'Ketik "DELETE" untuk konfirmasi penghapusan akun.',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        $name = $user->name;

        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                         ->with('success', "Akun {$name} berhasil dihapus.");
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,member',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User baru berhasil ditambahkan.');
    }
}
