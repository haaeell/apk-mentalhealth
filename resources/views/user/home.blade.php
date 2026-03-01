@extends('layouts.user')
@section('title', 'Beranda')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-indigo-200">Bagaimana perasaanmu hari ini?</p>
                </div>
                <a href="{{ route('user.diagnosa') }}"
                    class="px-6 py-3 bg-white text-indigo-700 font-bold rounded-xl hover:bg-indigo-50 transition-colors shadow">
                    Mulai Diagnosa Baru
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <!-- Recent Diagnoses -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-bold text-gray-900">Riwayat Diagnosa Terbaru</h2>
                        <a href="{{ route('user.riwayat') }}"
                            class="text-sm text-indigo-600 font-medium hover:underline">Lihat semua</a>
                    </div>

                    @if($recentDiagnoses->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">🧘</div>
                            <h3 class="font-semibold text-gray-700 mb-2">Belum ada diagnosa</h3>
                            <p class="text-gray-400 text-sm mb-4">Mulai diagnosa pertamamu untuk mengetahui kondisi kesehatan
                                mentalmu.</p>
                            <a href="{{ route('user.diagnosa') }}" class="btn-primary">Mulai Diagnosa</a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($recentDiagnoses as $d)
                                <a href="{{ route('user.hasil', $d->id) }}"
                                    class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                            style="background-color: {{ $d->primaryDisorder->color_code ?? '#6366f1' }}20;">
                                            🧠
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">
                                                {{ $d->primaryDisorder->name ?? 'Tidak Terdeteksi' }}</p>
                                            <p class="text-xs text-gray-400">{{ $d->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-bold text-indigo-600">{{ $d->cf_percentage }}%</div>
                                        <div class="text-xs text-gray-400">kepercayaan</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Statistik Saya</h3>
                    <div class="text-center">
                        <div class="text-4xl font-extrabold text-indigo-600">{{ $totalDiagnoses }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total Diagnosa</div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 rounded-2xl border border-blue-100 p-6">
                    <div class="text-2xl mb-3">💙</div>
                    <h3 class="font-bold text-blue-900 mb-2">Tips Kesehatan Mental</h3>
                    <ul class="text-sm text-blue-700 space-y-2">
                        @foreach([
                                'Istirahat yang cukup setiap hari',
                                'Ceritakan perasaan pada orang terpercaya',
                                'Olahraga ringan 30 menit sehari',
                                'Batasi penggunaan media sosial',
                                'Meditasi atau teknik pernapasan',
                            ] as $tip)
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-400 mt-0.5">•</span>
                                <span>{{ $tip }}</span>
                            </li>
                        @endforeach
                    </ul>

                                   </div>


                <!-- Warning -->
                <div class="bg-yellow-50 rounded-2xl border border-yellow-200 p-5">
                    <p class="text-yellow-800 text-xs leading-relaxed">
                        ⚠️ <strong>Perhatian:</strong> Hasil diagnosa adalah alat bantu awal. Jika Anda merasa membutuhkan bantuan,
                        segera hubungi profesional kesehatan mental atau hubungi hotline kesehatan jiwa <strong>119 ext 8</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection