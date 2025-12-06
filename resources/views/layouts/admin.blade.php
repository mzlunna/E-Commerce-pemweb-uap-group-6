<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    {{-- Sidebar / Navbar bisa ditambahkan di sini --}}
    <div class="min-h-screen flex">

        {{-- Konten Utama --}}
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>

</body>
</html>
