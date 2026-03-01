<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MentalCare')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('user.home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">MentalCare</span>
                </a>
                <div class="flex items-center space-x-1">
                    <a href="{{ route('user.home') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.home') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('user.diagnosa') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.diagnosa*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        Diagnosa
                    </a>
                    <a href="{{ route('user.riwayat') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.riwayat') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        Riwayat
                    </a>
                    <div class="ml-4 flex items-center space-x-3 pl-4 border-l border-gray-200">
                        <span class="text-sm text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 pt-4">
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm">{{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-400 text-sm py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>© {{ date('Y') }} MentalCare - Sistem Pendukung Keputusan Kesehatan Mental</p>
            <p class="mt-1 text-xs text-gray-500">Hasil diagnosa ini bukan pengganti konsultasi profesional kesehatan
                mental.</p>
        </div>
    </footer>

</body>

</html>