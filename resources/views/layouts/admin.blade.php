<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Admin CSS -->
    @vite(['resources/css/admin.css'])
</head>

<body class="bg-gray-100">

    <!-- NAVBAR -->
    <header class="admin-navbar">
        <button onclick="toggleSidebar()" class="hamburger md:hidden">☰</button>

        <h1 class="navbar-title">@yield('title', 'Admin Dashboard')</h1>

        <nav class="navbar-menu hidden md:flex">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}">Users</a>
            <a href="{{ route('admin.stores.index') }}">Stores</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn">Logout</button>
            </form>
        </nav>
    </header>

    <!-- SIDEBAR MOBILE -->
    <aside id="mobileSidebar" class="admin-sidebar hidden md:hidden">
        <button onclick="toggleSidebar()" class="sidebar-close">✕ Close</button>

        <h2 class="sidebar-title">Admin Menu</h2>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}">Users</a>
            <a href="{{ route('admin.stores.index') }}">Stores</a>
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </aside>

    <main class="p-4">
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('mobileSidebar').classList.toggle('hidden');
        }
    </script>

</body>
</html>