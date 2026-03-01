@extends('layouts.app')

@section('title', 'MentalCare - Kenali Kesehatan Mentalmu')

@section('content')
    <!-- Hero Section -->
    <div
        class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 min-h-screen flex items-center">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-300 rounded-full filter blur-3xl"></div>
        </div>

        <!-- Navbar Landing -->
        <div class="absolute top-0 left-0 right-0 z-10">
            <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-white text-xl">MentalCare</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.home') }}"
                            class="px-5 py-2 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-white/80 hover:text-white text-sm font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors text-sm">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 py-32 text-center">
            <div
                class="inline-flex items-center px-4 py-2 bg-white/10 border border-white/20 rounded-full text-white/90 text-sm mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                Sistem Berbasis Certainty Factor · Akurat & Terpercaya
            </div>

            <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                Kenali & Pahami<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-purple-300">Kesehatan
                    Mentalmu</span>
            </h1>

            <p class="text-xl text-indigo-200 max-w-2xl mx-auto mb-10">
                Dapatkan analisis kondisi kesehatan mental menggunakan metode <strong class="text-white">Certainty
                    Factor</strong>
                yang ilmiah. Cepat, privat, dan mudah digunakan.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ route('user.diagnosa') }}"
                        class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-lg hover:shadow-xl text-lg">
                        🧠 Mulai Diagnosa Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-lg hover:shadow-xl text-lg">
                        🧠 Mulai Diagnosa Gratis
                    </a>
                @endauth
                <a href="#cara-kerja"
                    class="px-8 py-4 bg-white/10 border border-white/30 text-white font-semibold rounded-2xl hover:bg-white/20 transition-all text-lg">
                    Pelajari Lebih Lanjut
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-lg mx-auto">
                <div>
                    <div class="text-3xl font-bold text-white">{{ $totalDiagnoses }}+</div>
                    <div class="text-indigo-300 text-sm mt-1">Diagnosa Dilakukan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">7</div>
                    <div class="text-indigo-300 text-sm mt-1">Jenis Gangguan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $totalUsers }}+</div>
                    <div class="text-indigo-300 text-sm mt-1">Pengguna Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cara Kerja -->
    <section id="cara-kerja" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Bagaimana Cara Kerjanya?</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Proses diagnosa sederhana dalam 3 langkah mudah menggunakan
                    algoritma Certainty Factor yang telah terbukti.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                        ['01', 'Isi Kuesioner', 'Jawab serangkaian pertanyaan seputar gejala yang Anda rasakan dengan tingkat keyakinan yang sesuai.', '📝', 'indigo'],
                        ['02', 'Analisis CF', 'Sistem menghitung nilai Certainty Factor untuk setiap gejala dan menggabungkannya secara ilmiah.', '🔬', 'purple'],
                        ['03', 'Lihat Hasil', 'Dapatkan hasil diagnosa lengkap dengan persentase kepercayaan dan rekomendasi tindakan.', '📊', 'green'],
                    ] as $step)
                    <div class="relative p-8 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-300">
                        <div class="text-5xl mb-4">{{ $step[3] }}</div>
                        <div class="text-xs font-bold text-{{ $step[4] }}-600 uppercase tracking-widest mb-2">Langkah {{ $step[0] }}</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $step[1] }}</h3>
                        <p class="text-gray-500 leading-relaxed">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Info CF -->
            <div class="mt-12 p-6 bg-indigo-50 rounded-2xl border border-indigo-100">
                <div class="flex items-start space-x-4">
                    <div class="text-2xl">💡</div>

                       <div>

                                               <h4 class="font-bold text-indigo-900 mb-1">Tentang Metode Certainty Factor</h4>

                                               <p class="text-indigo-700 text-sm leading-relaxed">
                            Certainty Factor (CF) adalah metode untuk merepresentasikan tingkat kepercayaan pada suatu hipotesis berdasarkan bukti yang ada.
                            CF = MB (Measure of Belief) - MD (Measure of Disbelief). Nilai CF berkisar -1 hingga +1, semakin mendekati 1 berarti semakin yakin.
                            Dalam sistem ini, jawaban Anda dikombinasikan dengan bobot medis oleh pakar untuk menghasilkan diagnosa yang akurat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gangguan yang dapat dideteksi -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Gangguan yang Dapat Dideteksi</h2>
                <p class="text-gray-500">Sistem kami dapat mengidentifikasi berbagai gangguan kesehatan mental umum.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($disorders as $disorder)
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $disorder->code }}</span>
                            <span class="badge-{{ $disorder->severity_color }}">{{ $disorder->severity_label }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">{{ $disorder->name }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ Str::limit($disorder->description, 100) }}</p>
                         <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                {{ $disorder->symptoms->count() ?? 0 }} gejala terkait
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->

               <section class="py-24 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-3xl mx-auto px-6 text-center">

                       <h2 class="text-3xl font-bold text-white mb-4">Mulai Perjalanan Menuju Kesehatan Mental yang Lebih Baik</h2>
            <p class="text-indigo-200 mb-8">Gratis, aman, dan terjaga privasinya. Daftar sekarang dan kenali kondisi mentalmu.</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-yellow-800 text-sm mb-8 inline-block">
                ⚠️ <strong>Penting:</strong> Hasil
                diagnosa ini merupakan alat bantu dan BUKAN pengganti konsultasi langsung dengan profesional kesehatan mental.
            </div>
            <br>
            @auth
                <a href="{{ route('user.diagnosa') }}" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-lg inline-block">
                    Mulai Diagnosa Sekarang →
                </a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-lg inline-block">
                    Daftar Sekarang, Gratis! →
                </a>
            @endauth
        </div>
    </section>
@endsection