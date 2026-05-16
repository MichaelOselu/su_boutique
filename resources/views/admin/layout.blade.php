<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            overflow-x: hidden;
        }
        body.sidebar-open {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100 overflow-x-hidden">

<div class="flex h-screen overflow-hidden">

    <!-- ========================= MOBILE OVERLAY ========================== -->
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- ========================= SIDEBAR ========================== -->
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50
                  w-72 bg-gray-900 text-white
                  transform -translate-x-full lg:translate-x-0
                  transition-transform duration-300 ease-in-out
                  flex flex-col">

        <!-- BRAND -->
        <div class="p-6 border-b border-gray-800 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold">Ecommerce Admin</h1>
                <p class="text-xs text-gray-400 mt-1">Store Management System</p>
            </div>

            <button id="close-sidebar"
                    class="lg:hidden text-2xl text-gray-400 hover:text-white">
                ✕
            </button>

        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-2">

            @php
                $active = 'bg-blue-600 text-white shadow-lg';
                $inactive = 'hover:bg-gray-800 text-gray-300';
            @endphp

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.dashboard') ? $active : $inactive }}">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.products.*') ? $active : $inactive }}">
                📦 Products
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.categories.*') ? $active : $inactive }}">
                🗂 Categories
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.orders.*') ? $active : $inactive }}">
                🛒 Orders
            </a>

            <a href="{{ route('admin.customers.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.customers.*') ? $active : $inactive }}">
                👥 Customers
            </a>

            <a href="{{ route('admin.sales.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.sales.*') ? $active : $inactive }}">
                💰 Sales
            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-gray-800 text-gray-300">
                ⚙ Settings
            </a>

        </nav>

        <!-- BOTTOM -->
        <div class="p-4 border-t border-gray-800">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-semibold">Admin</p>
                    <p class="text-xs text-gray-400 break-all">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-400 hover:text-red-300 text-sm">
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </aside>

    <!-- ========================= MAIN ========================== -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm border-b px-4 lg:px-8 py-4">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-4 min-w-0">

                    <button id="open-sidebar"
                            class="lg:hidden text-2xl text-gray-700">
                        ☰
                    </button>

                    <div class="min-w-0">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                            Admin Dashboard
                        </h2>

                        <p class="text-sm text-gray-500 truncate">
                            Manage your ecommerce store
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-4">

                    <button class="relative text-2xl text-gray-600 hover:text-blue-600">
                        🔔
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">
                            3
                        </span>
                    </button>

                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-700">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Administrator
                        </p>
                    </div>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8 min-w-0">

            @yield('content')

        </main>

    </div>

</div>

<!-- ========================= SIDEBAR SCRIPT ========================== -->
<script>

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    const openBtn = document.getElementById('open-sidebar');
    const closeBtn = document.getElementById('close-sidebar');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('sidebar-open');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('sidebar-open');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

</script>

</body>
</html>
