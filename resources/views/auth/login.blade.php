<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - My Ecommerce Store</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
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

<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- TOP BAR (same style as shop) -->
<div class="bg-gray-900 text-white text-xs sm:text-sm">

    <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col sm:flex-row justify-between gap-2">

        <div class="flex items-center gap-4 flex-wrap">
            <span>🚚 Fast Delivery</span>
            <span>🔒 Secure Payments</span>
        </div>

        <div class="flex items-center gap-4 flex-wrap">
            <span>📞 +254 700 000 000</span>
            <span class="hidden sm:block">✉ support@shop.com</span>
        </div>

    </div>

</div>

<!-- MAIN CONTENT -->
<main class="flex-1 flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">

        <!-- LOGIN CARD -->
        <div class="bg-white rounded-lg shadow-lg p-8">

            <!-- HEADER -->
            <div class="mb-6 text-center">

                <h1 class="text-3xl font-bold text-gray-800">
                    Welcome Back
                </h1>

                <p class="text-gray-500 mt-1">
                    Login to your account to continue shopping
                </p>

            </div>

            <!-- SESSION STATUS -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email"
                    >

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password"
                    >

                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- REMEMBER + FORGOT -->
                <div class="flex items-center justify-between text-sm">

                    <label class="flex items-center gap-2 text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-blue-600 hover:underline">
                            Forgot password?
                        </a>
                    @endif

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition font-semibold">

                    Log In

                </button>

            </form>

            <!-- FOOTER LINK -->
            <div class="mt-6 text-center text-sm text-gray-600">

                Don’t have an account?

                <a href="{{ route('register') }}"
                   class="text-blue-600 hover:underline font-medium">
                    Register
                </a>

            </div>

        </div>

    </div>

</main>

<!-- FOOTER (same minimal style) -->
<footer class="bg-gray-900 text-gray-400 text-center text-sm py-4 mt-10">

    © {{ date('Y') }} My Ecommerce Store. All rights reserved.

</footer>

</body>
</html>
