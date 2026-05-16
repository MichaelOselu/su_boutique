<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    <!-- ✅ USING CDN TAILWIND (MATCHING YOUR WORKING FRONTEND) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen overflow-x-hidden">

<div class="flex h-screen overflow-hidden">

    <!-- =========================
         MOBILE OVERLAY
    ========================== -->
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- =========================
         SIDEBAR (MATCHED STYLE)
    ========================== -->
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50
                  w-72 bg-gray-900 text-white
                  transform -translate-x-full lg:translate-x-0
                  transition-transform duration-300 ease-in-out
                  flex flex-col shadow-xl">

        <!-- BRAND -->
        <div class="p-6 border-b border-gray-800 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-extrabold tracking-tight">
                    Ecommerce Admin
                </h1>

                <p class="text-xs text-gray-400 mt-1">
                    Store Management System
                </p>
            </div>

            <button id="close-sidebar"
                    class="lg:hidden text-2xl text-gray-400 hover:text-white transition">
                ✕
            </button>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-2">

            @php
                $active = 'bg-blue-600 text-white shadow';
                $inactive = 'text-gray-300 hover:bg-gray-800 hover:text-white';
            @endphp

            @foreach([
                ['route' => 'admin.dashboard', 'icon' => '📊', 'label' => 'Dashboard'],
                ['route' => 'admin.products.index', 'icon' => '📦', 'label' => 'Products'],
                ['route' => 'admin.categories.index', 'icon' => '🗂', 'label' => 'Categories'],
                ['route' => 'admin.orders.index', 'icon' => '🛒', 'label' => 'Orders'],
                ['route' => 'admin.customers.index', 'icon' => '👥', 'label' => 'Customers'],
                ['route' => 'admin.sales.index', 'icon' => '💰', 'label' => 'Sales'],
            ] as $item)

                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                   {{ request()->routeIs($item['route'].'*') ? $active : $inactive }}">

                    <span class="text-lg">{{ $item['icon'] }}</span>
                    <span class="font-medium">{{ $item['label'] }}</span>

                </a>

            @endforeach

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition">

                <span class="text-lg">⚙</span>
                <span class="font-medium">Settings</span>

            </a>

        </nav>

        <!-- USER FOOTER -->
        <div class="p-4 border-t border-gray-800">

            <div class="flex items-center justify-between">

                <div class="min-w-0">
                    <p class="text-sm font-semibold truncate">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-400 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="text-red-400 hover:text-red-300 text-sm transition">
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </aside>

    <!-- =========================
         MAIN CONTENT
    ========================== -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- TOPBAR (MATCHED STYLE) -->
        <header class="bg-white shadow sticky top-0 z-30">

            <div class="px-4 lg:px-8 py-4">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-4">

                        <button id="open-sidebar"
                                class="lg:hidden text-2xl text-gray-700">
                            ☰
                        </button>

                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                                Admin Dashboard
                            </h2>

                            <p class="text-sm text-gray-500">
                                Manage your ecommerce store
                            </p>
                        </div>

                    </div>

                    <div class="flex items-center gap-4">

                        <button class="relative text-2xl text-gray-600 hover:text-blue-600 transition">
                            🔔

                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px]
                                         w-5 h-5 rounded-full flex items-center justify-center font-bold">
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

            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 overflow-y-auto">

            <div class="max-w-7xl mx-auto px-4 py-6">

                @yield('content')

            </div>

        </main>

    </div>

</div>

<!-- =========================
     SIDEBAR SCRIPT
========================= -->
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
