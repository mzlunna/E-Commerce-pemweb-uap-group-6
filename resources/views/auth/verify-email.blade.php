@extends('layouts.auth')

@vite(['resources/css/auth.css'])

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Verifikasi Email</h2>

        <p class="auth-subtitle">Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi email Anda dengan mengklik tautan yang kami kirimkan</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                Tautan verifikasi baru telah dikirim ke email Anda
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="form-inline">
            @csrf
            <button type="submit" class="btn-submit">Kirim Ulang Email Verifikasi</button>
        </form>

        <div class="form-divider">
            <p>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="link-logout">Logout</button>
                </form>
            </p>
        </div>
    </div>
</div>
@endsection