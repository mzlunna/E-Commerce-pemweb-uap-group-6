<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');  // Halaman dashboard user
    }

    public function home()
    {
        return view('user.home');  // Halaman produk atau halaman utama untuk user
    }
}
