@extends('layouts.auth')

@vite(['resources/css/auth.css'])

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Lupa Password</h2>

        <p class="auth-subtitle">Masukkan email Anda untuk menerima link reset password</p>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="form-input" 
                    placeholder="Email"
                    required>
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-submit">Kirim Link Reset</button>

            <div class="form-divider">
                <p><a href="{{ route('login') }}">Kembali ke Login</a></p>
            </div>
        </form>
    </div>
</div>
@endsection