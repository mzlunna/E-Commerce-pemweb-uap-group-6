@extends('layouts.auth')

@vite(['resources/css/auth.css'])

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input 
                    class="form-input" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Email" 
                    required 
                    autofocus>
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <input 
                    class="form-input" 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    required>
                @if ($errors->has('password'))
                    <span class="form-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-submit">Login</button>

            <div class="form-footer">
                <a href="{{ route('password.request') }}">Lupa password?</a>
            </div>
        </form>

        <div class="form-divider">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
        </div>
    </div>
</div>
@endsection
