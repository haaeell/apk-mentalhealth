@extends('layouts.user')
@section('title', 'Diagnosa Kesehatan Mental')
@section('content')

    <div class="max-w-4xl mx-auto px-4 py-8" x-data="diagnosaApp()">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Diagnosa Kesehatan Mental</h1>
            <p class="text-gray-500">Pilih tingkat kesesuaian gejala yang Anda rasakan. Jawab dengan jujur untuk hasil yang
                akurat.</p>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Progress Pengisian</span>
                <span class="text-sm font-bold text-indigo-600"
                    x-text="answeredCount + ' / {{ $totalSymptoms }} Gejala'"></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500"
                    :style="'width: ' + (answeredCount / {{ $totalSymptoms }} * 100) + '%'"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">Anda tidak harus menjawab semua, pilih yang relevan saja.</p>
        </div>

        <!-- Skala CF Info -->
        <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-5 mb-6">
            <h3 class="font-bold text-indigo-900 mb-3">📊 Panduan Pilihan Jawaban</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach(App\Services\CertaintyFactorService::cfUserScale() as $val => $info)
                    <div class="bg-white rounded-xl p-3 border border-indigo-100">
                        <div class="font-semibold text-gray-800 text-sm">{{ $info['label'] }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $info['desc'] }}</div>
                        <div class="text-xs font-mono text-indigo-600 mt-1">CF = {{ number_format($val, 1) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FORM: hapus @submit.prevent, biarkan submit native --}}
        <form id="diagnosaForm" action="{{ route('user.diagnosa.process') }}" method="POST">
            @csrf

            @foreach($symptoms as $category => $categorySymptoms)
                <div class="mb-8">
                    <!-- Category Header -->
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-px h-8 bg-indigo-500"></div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-lg">
                                @php
                                    $categoryMap = [
                                        'emosi' => '🧡 Gejala Emosi',
                                        'perilaku' => '🟢 Gejala Perilaku',
                                        'fisik' => '🔵 Gejala Fisik',
                                        'kognitif' => '🟣 Gejala Kognitif',
                                        'umum' => '⚪ Gejala Umum',
                                    ];
                                @endphp
                                {{ $categoryMap[$category] ?? ucfirst($category) }}
                            </h2>
                            <p class="text-xs text-gray-400">{{ $categorySymptoms->count() }} gejala</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($categorySymptoms as $symptom)
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:border-indigo-200 transition-colors">
                                <div class="flex items-start space-x-3 mb-4">
                                    <div
                                        class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0 text-xs font-bold text-indigo-600">
                                        {{ $symptom->code }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $symptom->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-0.5">{{ $symptom->question }}</p>
                                        <p class="text-xs text-gray-400 mt-1 italic">{{ $symptom->description }}</p>
                                    </div>
                                </div>

                                <!-- CF Options -->
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach($cfScale as $val => $info)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="answers[{{ $symptom->id }}]" value="{{ $val }}"
                                                @change="updateCount" class="sr-only peer">
                                            <div
                                                class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-indigo-300 transition-all text-center">
                                                <div class="font-medium text-gray-800 text-sm">{{ $info['label'] }}</div>
                                                <div class="text-xs text-gray-400">CF: {{ number_format($val, 1) }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Submit Bar (sticky) -->
            <div class="sticky bottom-6 z-10">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">
                                <span x-text="answeredCount"></span> gejala dipilih
                            </p>
                            <p class="text-sm text-gray-500">Minimal 1 gejala untuk melanjutkan</p>
                        </div>

                        {{-- Tombol ini sekarang langsung submit form native via x-on:click --}}
                        <button type="button" @click="handleSubmit" :disabled="isLoading" :class="answeredCount > 0 && !isLoading
                                    ? 'bg-indigo-600 hover:bg-indigo-700 shadow-lg cursor-pointer'
                                    : 'bg-gray-300 cursor-not-allowed'"
                            class="px-8 py-3 text-white font-bold rounded-xl transition-all text-sm flex items-center gap-2">
                            <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span x-text="isLoading ? 'Menganalisis...' : '🔬 Analisis Sekarang'"></span>
                        </button>
                    </div>

                    <!-- Pesan error jika belum pilih gejala -->
                    <p x-show="showError" x-transition class="text-red-500 text-xs mt-2 font-medium">
                        ⚠️ Silakan pilih minimal satu gejala terlebih dahulu.
                    </p>
                </div>
            </div>

        </form>
    </div>

    <script>
        function diagnosaApp() {
            return {
                answeredCount: 0,
                isLoading: false,
                showError: false,

                updateCount() {
                    const radios = document.querySelectorAll('#diagnosaForm input[type="radio"]:checked');
                    let count = 0;
                    radios.forEach(r => {
                        if (parseFloat(r.value) > 0) count++;
                    });
                    this.answeredCount = count;
                    if (count > 0) this.showError = false;
                },

                handleSubmit() {
                    if (this.answeredCount === 0) {
                        this.showError = true;
                        // Scroll ke atas supaya user tahu belum pilih apapun
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        return;
                    }
                    this.isLoading = true;
                    this.showError = false;
                    document.getElementById('diagnosaForm').submit();
                }
            }
        }
    </script>
@endsection