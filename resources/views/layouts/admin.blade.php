<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - MentalCare Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>


<style>
    /* Controls bar */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1.25rem;
    }

    .dataTables_wrapper .dataTables_filter {
        float: none !important;
        display: flex;
        justify-content: flex-end;
    }

    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #9ca3af;
        font-weight: 500;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        outline: none;
        width: 220px;
        background: #f9fafb;
        transition: all 0.2s;
        color: #374151;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.45rem 0.75rem;
        font-size: 0.8rem;
        background: #f9fafb;
        outline: none;
        cursor: pointer;
        color: #374151;
    }

    /* Table overrides */
    table.dataTable {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
    }

    table.dataTable thead th {
        background: #f9fafb !important;
        font-size: 0.7rem !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.07em !important;
        color: #9ca3af !important;
        padding: 0.875rem 1rem !important;
        border: none !important;
        border-bottom: 1px solid #f3f4f6 !important;
        white-space: nowrap;
    }

    table.dataTable thead th.sorting:after,
    table.dataTable thead th.sorting_asc:after,
    table.dataTable thead th.sorting_desc:after {
        opacity: 0.3 !important;
    }

    table.dataTable tbody td {
        padding: 0.85rem 1rem !important;
        border: none !important;
        border-bottom: 1px solid #f9fafb !important;
        vertical-align: middle;
        color: #374151;
    }

    table.dataTable tbody tr:hover td {
        background-color: #fafafa !important;
    }

    table.dataTable tbody tr:last-child td {
        border-bottom: none !important;
    }

    /* Bottom bar */
    .dataTables_wrapper .dataTables_info {
        font-size: 0.78rem;
        color: #9ca3af;
        padding-top: 1rem;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.75rem;
        display: flex;
        gap: 0.2rem;
        align-items: center;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.6rem !important;
        font-size: 0.8rem !important;
        border-radius: 0.6rem !important;
        border: none !important;
        background: transparent !important;
        color: #6b7280 !important;
        cursor: pointer;
        transition: all 0.15s;
        box-shadow: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e0e7ff !important;
        color: #4338ca !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #6366f1 !important;
        color: white !important;
        font-weight: 600 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #d1d5db !important;
        cursor: not-allowed;
        background: transparent !important;
    }
</style>
@stack('styles')

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="bg-gradient-to-b from-indigo-900 to-indigo-800 text-white transition-all duration-300 flex flex-col"
            :class="sidebarOpen ? 'w-64' : 'w-16'">
            <!-- Logo -->
            <div class="flex items-center h-16 px-4 border-b border-indigo-700">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg" x-show="sidebarOpen" x-transition>MentalCare</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 px-2">
                <div class="mb-2 px-3 text-xs font-semibold text-indigo-300 uppercase tracking-wider"
                    x-show="sidebarOpen">Menu</div>

                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.disorders.index', 'label' => 'Gangguan Mental', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['route' => 'admin.symptoms.index', 'label' => 'Gejala', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['route' => 'admin.users.index', 'label' => 'Pengguna', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ];
                @endphp

                @foreach($navItems as $item)
                            <a href="{{ route($item['route']) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl mb-1 transition-all duration-200
                                                                                                          {{ request()->routeIs($item['route'] . '*')
                    ? 'bg-white/20 text-white font-medium'
                    : 'text-indigo-200 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                                <span x-show="sidebarOpen" x-transition class="text-sm">{{ $item['label'] }}</span>
                            </a>
                @endforeach
            </nav>

            <!-- User Info bottom -->
            <div class="mt-auto p-3 border-t border-indigo-700">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-indigo-300">Administrator</p>
                    </div>
                    <form x-show="sidebarOpen" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-indigo-300 hover:text-white transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-sm text-gray-500">{{ now()->format('d M Y') }}</div>
                    <div
                        class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div
                        class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @stack('scripts')

</body>

</html>