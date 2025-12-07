<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('mobileSidebar').classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-gray-100">

    <!-- NAVBAR (Desktop + Mobile) -->
    <header class="w-full bg-white shadow p-4 flex justify-between items-center sticky top-0 z-40">

        <!-- Hamburger Mobile -->
        <button onclick="toggleSidebar()" class="md:hidden text-2xl">
            ☰
        </button>

        <h1 class="text-xl font-bold">@yield('title', 'Admin Dashboard')</h1>

        <!-- MENU DESKTOP -->
        <nav class="hidden md:flex items-center gap-6 text-gray-800">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-500">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="hover:text-blue-500">Users</a>
            <a href="{{ route('admin.stores.index') }}" class="hover:text-blue-500">Stores</a>
            <a href="{{ route('admin.orders.index') }}" class="hover:text-blue-500">Orders</a>
            <a href="{{ route('admin.withdrawals.index') }}" class="hover:text-blue-500">Withdrawals</a>

            <!-- Logout Desktop -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="py-2 px-4 bg-blue-900 text-white rounded hover:bg-blue-800">
                    Logout
                </button>
            </form>
        </nav>

    </header>

    <!-- SIDEBAR MOBILE -->
    <aside id="mobileSidebar"
           class="w-64 bg-white shadow-md p-5 fixed top-0 left-0 h-full hidden z-50 md:hidden">

        <!-- Close -->
        <button onclick="toggleSidebar()" class="mb-5 text-right w-full text-gray-600 text-lg">
            ✕ Close
        </button>

        <h2 class="text-xl font-bold mb-6">Admin Menu</h2>

        <nav class="flex flex-col gap-3">
            <a href="{{ route('admin.dashboard') }}" class="py-2 px-3 rounded hover:bg-gray-200">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="py-2 px-3 rounded hover:bg-gray-200">Users</a>
            <a href="{{ route('admin.stores.index') }}" class="py-2 px-3 rounded hover:bg-gray-200">Stores</a>
            <a href="{{ route('admin.orders.index') }}" class="py-2 px-3 rounded hover:bg-gray-200">Orders</a>
            <a href="{{ route('admin.withdrawals.index') }}" class="py-2 px-3 rounded hover:bg-gray-200">Withdrawals</a>
        </nav>

        <!-- Logout Mobile -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
                 <button class="py-2 px-4 bg-blue-900 text-white rounded hover:bg-blue-800">
                Logout
            </button>
        </form>
    </aside>

    <!-- CONTENT -->
    <main class="p-4">
        @yield('content')
    </main>

</body>
</html>
