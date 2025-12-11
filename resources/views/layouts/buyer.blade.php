<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ELSHOP - Snack E-Commerce')</title>
    
    {{-- VITE CSS & JS --}}
    @vite(['resources/css/buyer.css', 'resources/js/buyer.js'])
    
    @stack('styles')
</head>
<body>
    {{-- HEADER --}}
    <x-buyer-header />

    {{-- MAIN CONTENT --}}
    <main class="buyer-container">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <strong>✓</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <strong>✗</strong> {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <strong>ℹ</strong> {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    <x-buyer-footer />
    
    @stack('scripts')
</body>
</html>