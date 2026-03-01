@extends('layouts.user')
@section('title', 'Hasil Diagnosa')
@section('content')

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Back -->
        <a href="{{ route('user.riwayat') }}"
            class="inline-flex items-center text-gray-500 hover:text-gray-700 mb-6 text-sm">
            ← Kembali ke Riwayat
        </a>

        @if($diagnosis->primary_disorder_id)
            <!-- Main Result Card -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-8 text-white mb-6 shadow-xl">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-indigo-200 text-sm font-medium mb-1">Hasil Diagnosa Utama</div>
                        <h1 class="text-2xl font-extrabold mb-2">{{ $diagnosis->primaryDisorder->name }}</h1>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                                Tingkat: {{ $diagnosis->primaryDisorder->severity_label }}
                            </span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                                {{ $diagnosis->primaryDisorder->code }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-5xl font-extrabold">{{ $diagnosis->cf_percentage }}%</div>
                        <div class="text-indigo-200 text-sm">Tingkat Kepercayaan CF</div>
                        <div class="text-xs text-indigo-300 mt-1">{{ $diagnosis->confidence_label }}</div>
                    </div>
                </div>

                <!-- CF Progress -->
                <div class="mt-4">
                    <div class="w-full bg-white/20 rounded-full h-3">
                        <div class="bg-white h-3 rounded-full transition-all" style="width: {{ $diagnosis->cf_percentage }}%">
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-sm text-indigo-200">
                    Dianalisis pada {{ $diagnosis->created_at->format('d F Y, H:i') }} WIB
                </div>
            </div>

            <!-- Penjelasan Gangguan -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
                <h2 class="font-bold text-gray-900 text-lg mb-3">📖 Tentang {{ $diagnosis->primaryDisorder->name }}</h2>
                <p class="text-gray-600 leading-relaxed">{{ $diagnosis->primaryDisorder->description }}</p>
            </div>

            <!-- Rekomendasi -->
            <div class="bg-green-50 rounded-2xl border border-green-200 p-6 mb-6">
                <h2 class="font-bold text-green-900 text-lg mb-4">✅ Rekomendasi Tindakan</h2>
                <div class="space-y-2">
                    @foreach(explode("\n", $diagnosis->primaryDisorder->recommendation) as $rec)
                        @if(trim($rec))
                            <div class="flex items-start space-x-3">
                                <span class="text-green-500 font-bold flex-shrink-0">→</span>
                                <span class="text-green-800 text-sm">{{ trim($rec) }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        @else
            <!-- Healthy Result -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-8 text-white mb-6 text-center">
                <div class="text-6xl mb-4">🌟</div>
                <h1 class="text-2xl font-extrabold mb-2">Tidak Terdeteksi Gangguan Signifikan</h1>
                <p class="text-green-100">Berdasarkan gejala yang Anda pilih, tidak ditemukan indikasi gangguan mental yang
                    signifikan. Tetap jaga kesehatan mentalmu!</p>
            </div>
        @endif

        <!-- Semua Hasil CF -->
        @if(!empty($allResults))
            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
                <h2 class="font-bold text-gray-900 mb-4">📊 Perbandingan Semua Hasil Analisis</h2>
                <div class="space-y-4">
                    @foreach($allResults as $i => $result)
                        <div class="flex items-center space-x-4">
                            <div class="w-6 text-center text-sm font-bold text-gray-400">{{ $i + 1 }}</div>
                            <div class="flex-1">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $result['disorder']->name }}</span>
                                    <span class="text-sm font-bold"
                                        style="color: {{ $result['disorder']->color_code }}">{{ $result['percentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all"
                                        style="width: {{ $result['percentage'] }}%; background-color: {{ $result['disorder']->color_code }}">
                                    </div>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">CF = {{ number_format($result['cf'], 4) }} ·
                                    {{ $result['disorder']->severity_label }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Gejala yang Dipilih -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">🔍 Gejala yang Anda Pilih</h2>
            <div class="grid md:grid-cols-2 gap-3">
                @foreach($userSymptoms as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <span
                                class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded">{{ $item['symptom']->code }}</span>
                            <span class="text-sm text-gray-700">{{ $item['symptom']->name }}</span>
                        </div>
                        <span class="text-xs font-medium text-gray-500">CF: {{ number_format($item['cf_user'], 1) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Warning -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 mb-6">
            <h3 class="font-bold text-yellow-900 mb-2">⚠️ Penting untuk Diketahui</h3>
            <p class="text-yellow-800 text-sm leading-relaxed">
                Hasil diagnosa ini dihasilkan oleh sistem berbasis Certainty Factor dan bersifat sebagai <strong>alat bantu
                    awal</strong>.
                Hasil ini BUKAN diagnosis medis resmi dan tidak dapat menggantikan konsultasi langsung dengan psikiater,
                psikolog, atau tenaga kesehatan jiwa profesional.
                Jika Anda merasa tertekan atau membutuhkan bantuan segera, hubungi <strong>Hotline Kesehatan Jiwa: 119 ext
                    8</strong>.
            </p>
        </div>

        <!-- Actions -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('user.diagnosa') }}" class="btn-primary">
                🔄 Diagnosa Ulang
            </a>
            <a href="{{ route('user.riwayat') }}" class="btn-secondary">
                📋 Lihat Riwayat
            </a>
            <button onclick="window.print()" class="btn-secondary">
                🖨️ Cetak Hasil
            </button>
        </div>
    </div>
@endsection