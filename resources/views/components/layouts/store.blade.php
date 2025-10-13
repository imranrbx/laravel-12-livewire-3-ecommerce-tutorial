<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- 🧭 Navbar --}}
    <header class=" bg-white border-b shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                Perfect<span class="text-gray-800">Store</span>
            </a>

            <nav class="flex items-center gap-6">
                <a href="{{ route('store.products') }}"
                    class="text-gray-700 hover:text-indigo-600 font-medium transition">Products</a>
                <a href="{{ route('store.cart') }}"
                    class="text-gray-700 hover:text-indigo-600 font-medium transition">Cart</a>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-gray-700 hover:text-indigo-600 font-medium transition">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-700 hover:text-indigo-600 font-medium transition">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- 🔔 Flash Notifications --}}
    <div class="fixed top-4 right-4 z-50 space-y-2">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="flex items-center p-4 text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-md"
                role="alert">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 4.293 10.879a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="flex items-center p-4 text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-md"
                role="alert">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zM9 4a1 1 0 012 0v4a1 1 0 01-2 0V4zm1 8a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    {{-- 🧩 Main Content --}}
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    {{-- ⚙️ Footer --}}
    <footer class="border-t bg-white mt-8">

        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-600">
            © {{ date('Y') }} Perfect Web Solutions. All
        </div>
    </footer>
    @fluxScripts
</body>

</html>