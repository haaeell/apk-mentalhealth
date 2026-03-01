@extends('layouts.admin')
@section('title', 'Tambah Gangguan Mental')
@section('page-title', 'Tambah Gangguan Mental')
@section('content')

    <div class="max-w-3xl" x-data="{ selectedSymptoms: [] }">
        <form action="{{ route('admin.disorders.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Info Dasar -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Gangguan</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="code" value="{{ old('code') }}" class="input-field" placeholder="P001"
                                required>
                            @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Keparahan <span
                                    class="text-red-500">*</span></label>
                            <select name="severity" class="input-field" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="ringan" {{ old('severity') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('severity') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('severity') == 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Gangguan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" rows="3" class="input-field resize-none"
                                required>{{ old('description') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi Tindakan <span
                                    class="text-red-500">*</span></label>
                            <textarea name="recommendation" rows="4" class="input-field resize-none" placeholder="1. ..."
                                required>{{ old('recommendation') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Warna (Hex)</label>
                            <input type="color" name="color_code" value="{{ old('color_code', '#6366f1') }}"
                                class="h-10 w-full rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Gejala & Nilai CF -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900">Bobot Gejala (MB & MD)</h3>
                        <button type="button" @click="selectedSymptoms.push({id: '', mb: 0.5, md: 0.1})"
                            class="text-sm text-indigo-600 font-medium hover:underline">+ Tambah Gejala</button>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-4 mb-4 text-blue-800 text-sm">
                        <strong>📘 Panduan:</strong> MB = Measure of Belief (kepercayaan gejala menunjukkan gangguan ini),
                        MD = Measure of Disbelief (ketidakpercayaan). MB + MD ≤ 1. CF = MB - MD.
                    </div>

                    <template x-for="(sym, index) in selectedSymptoms" :key="index">
                        <div class="flex items-center space-x-3 mb-3 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-1">
                                <select :name="'symptoms[' + index + '][id]'" x-model="sym.id" class="input-field text-sm">
                                    <option value="">Pilih Gejala</option>
                                    @foreach($symptoms as $s)
                                        <option value="{{ $s->id }}">{{ $s->code }} - {{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-28">
                                <label class="text-xs text-gray-500 mb-1 block">MB (0-1)</label>
                                <input type="number" :name="'symptoms[' + index + '][mb]'" x-model="sym.mb" step="0.01"
                                    min="0" max="1" class="input-field text-sm">
                            </div>
                            <div class="w-28">
                                <label class="text-xs text-gray-500 mb-1 block">MD (0-1)</label>
                                <input type="number" :name="'symptoms[' + index + '][md]'" x-model="sym.md" step="0.01"
                                    min="0" max="1" class="input-field text-sm">
                            </div>
                            <button type="button" @click="selectedSymptoms.splice(index, 1)"
                                class="text-red-400 hover:text-red-600 mt-4">✕</button>
                        </div>
                    </template>

                    <div x-show="selectedSymptoms.length === 0" class="text-center py-8 text-gray-400 text-sm">
                        Belum ada gejala ditambahkan. Klik "+ Tambah Gejala" di atas.
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <button type="submit" class="btn-primary">Simpan Gangguan</button>
                    <a href="{{ route('admin.disorders.index') }}" class="btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection