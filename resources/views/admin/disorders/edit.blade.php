@extends('layouts.admin')
@section('title', 'Edit Gangguan Mental')
@section('page-title', 'Edit Gangguan Mental')
@section('content')

    <div class="max-w-3xl" x-data="{
            selectedSymptoms: {{ json_encode($disorderSymptoms->map(fn($ds) => ['id' => $ds->symptom_id, 'mb' => $ds->mb, 'md' => $ds->md])) }},
            imagePreview: '{{ $disorder->image ? Storage::url($disorder->image) : '' }}'
        }">
        <form action="{{ route('admin.disorders.update', $disorder) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">

                <!-- Info Dasar -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Gangguan</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="code" value="{{ old('code', $disorder->code) }}" class="input-field"
                                required>
                            @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Keparahan <span
                                    class="text-red-500">*</span></label>
                            <select name="severity" class="input-field" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="ringan" {{ old('severity', $disorder->severity) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('severity', $disorder->severity) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('severity', $disorder->severity) == 'berat' ? 'selected' : '' }}>
                                    Berat</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Gangguan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $disorder->name) }}" class="input-field"
                                required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" rows="3" class="input-field resize-none"
                                required>{{ old('description', $disorder->description) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi Tindakan <span
                                    class="text-red-500">*</span></label>
                            <textarea name="recommendation" rows="4" class="input-field resize-none"
                                required>{{ old('recommendation', $disorder->recommendation) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Warna (Hex)</label>
                            <input type="color" name="color_code"
                                value="{{ old('color_code', $disorder->color_code ?? '#6366f1') }}"
                                class="h-10 w-full rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="is_active" class="input-field">
                                <option value="1" {{ old('is_active', $disorder->is_active) == 1 ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ old('is_active', $disorder->is_active) == 0 ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Foto -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Foto Gangguan</h3>
                    <div class="flex items-start gap-5">
                        <!-- Preview -->
                        <div class="flex-shrink-0">
                            <template x-if="imagePreview">
                                <img :src="imagePreview"
                                    class="w-28 h-28 rounded-2xl object-cover border border-gray-100 shadow-sm">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="w-28 h-28 rounded-2xl bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                        <!-- Upload -->
                        <div class="flex-1">
                            <label
                                class="block w-full border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-all">
                                <svg class="w-6 h-6 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm text-gray-500">Klik untuk upload foto baru</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP maks. 2MB</p>
                                <input type="file" name="image" accept="image/*" class="hidden"
                                    @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            </label>
                            @if($disorder->image)
                                <label class="flex items-center gap-2 mt-3 text-sm text-gray-500 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded">
                                    Hapus foto saat ini
                                </label>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Gejala & Nilai CF -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900">Bobot Gejala (MB & MD)</h3>
                        <button type="button" @click="selectedSymptoms.push({id: '', mb: 0.5, md: 0.1})"
                            class="text-sm text-indigo-600 font-medium hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Gejala
                        </button>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-4 mb-4 text-blue-800 text-sm">
                        <strong>📘 Panduan:</strong> MB = Measure of Belief, MD = Measure of Disbelief. MB + MD ≤ 1. CF = MB
                        - MD.
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
                                class="text-red-400 hover:text-red-600 mt-4 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>

                    <div x-show="selectedSymptoms.length === 0" class="text-center py-8 text-gray-400 text-sm">
                        Belum ada gejala. Klik "+ Tambah Gejala" di atas.
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.disorders.index') }}" class="btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection