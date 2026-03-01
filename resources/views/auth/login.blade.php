@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex">
        <!-- Left Panel -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-900 to-purple-900 text-white flex-col justify-center items-center p-12">
            <div class="text-6xl mb-6">🧠</div>
            <h1 class="text-3xl font-extrabold mb-4 text-center">MentalCare SPK</h1>
            <p class="text-indigo-200 text-center leading-relaxed max-w-sm">
                Sistem Pendukung Keputusan Kesehatan Mental menggunakan metode Certainty Factor yang ilmiah dan terpercaya.
            </p>
            <div class="mt-8 grid grid-cols-2 gap-4 text-center">
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="text-2xl font-bold">7+</div>
                    <div class="text-indigo-200 text-xs">Jenis Gangguan</div>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="text-2xl font-bold">20+</div>
                    <div class="text-indigo-200 text-xs">Parameter Gejala</div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="{{ route('landing') }}" class="inline-flex items-center space-x-2 mb-6">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900 text-xl">MentalCare</span>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h2>
                    <p class="text-gray-500 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if(session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
                        {{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field"
                            placeholder="nama@email.com" required autofocus>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-sm font-medium text-gray-700">Password</label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:underline">Lupa
                                    password?</a>
                            @endif
                        </div>
                        <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="rounded border-gray-300 text-indigo-600 mr-2">
                        <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        Masuk
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Daftar
                        sekarang</a>
                </div>

                <!-- Demo accounts -->
                <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-medium text-gray-600 mb-2">🔑 Akun Demo:</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <div><strong>Admin:</strong> admin@mental.com / admin123</div>
                        <div><strong>User:</strong> user@mental.com / user123</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection