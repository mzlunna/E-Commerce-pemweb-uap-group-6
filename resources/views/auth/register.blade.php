@extends('layouts.auth')

@vite(['resources/css/auth.css'])

@section('content')
<div class="register-wrapper">
    <div class="register-card">
        <h2>Daftar Akun</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    class="form-input" 
                    placeholder="Nama Lengkap"
                    required>
                @if ($errors->has('name'))
                    <span class="form-error">{{ $errors->first('name') }}</span>
                @endif
            </div>

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

            <div class="form-group">
                <input 
                    type="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Password"
                    required>
                @if ($errors->has('password'))
                    <span class="form-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group">
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="form-input" 
                    placeholder="Konfirmasi Password"
                    required>
                @if ($errors->has('password_confirmation'))
                    <span class="form-error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-submit">Daftar</button>

            <div class="form-divider">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
