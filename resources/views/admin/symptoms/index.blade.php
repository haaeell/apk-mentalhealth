@extends('layouts.admin')
@section('title', 'Manajemen Gejala')
@section('page-title', 'Manajemen Gejala')

@push('styles')
<style>
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.2rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .cat-emosi    { background: #fef3c7; color: #92400e; }
    .cat-perilaku { background: #d1fae5; color: #065f46; }
    .cat-fisik    { background: #dbeafe; color: #1e40af; }
    .cat-kognitif { background: #ede9fe; color: #5b21b6; }
    .cat-umum     { background: #f3f4f6; color: #374151; }
</style>
@endpush

@section('content')

<div class="grid lg:grid-cols-5 gap-6">

    <!-- Form Tambah -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-20">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Tambah Gejala Baru</h3>
                    <p class="text-xs text-gray-400">Isi semua field yang diperlukan</p>
                </div>
            </div>

            <form action="{{ route('admin.symptoms.store') }}" method="POST" class="space-y-3">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kode <span class="text-red-500">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}"
                            class="input-field text-sm @error('code') border-red-400 @enderror"
                            placeholder="G001" required>
                        @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" class="input-field text-sm" required>
                            <option value="umum"     {{ old('category') == 'umum'     ? 'selected' : '' }}>⚪ Umum</option>
                            <option value="emosi"    {{ old('category') == 'emosi'    ? 'selected' : '' }}>🧡 Emosi</option>
                            <option value="perilaku" {{ old('category') == 'perilaku' ? 'selected' : '' }}>🟢 Perilaku</option>
                            <option value="fisik"    {{ old('category') == 'fisik'    ? 'selected' : '' }}>🔵 Fisik</option>
                            <option value="kognitif" {{ old('category') == 'kognitif' ? 'selected' : '' }}>🟣 Kognitif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Gejala <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="input-field text-sm @error('name') border-red-400 @enderror" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Klinis <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="2"
                        class="input-field text-sm resize-none @error('description') border-red-400 @enderror"
                        required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Pertanyaan untuk User <span class="text-red-500">*</span></label>
                    <textarea name="question" rows="2"
                        class="input-field text-sm resize-none @error('question') border-red-400 @enderror"
                        placeholder="Apakah Anda sering..." required>{{ old('question') }}</textarea>
                    @error('question') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full btn-primary justify-center flex items-center gap-2 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Gejala
                </button>
            </form>
        </div>
    </div>

    <!-- List Gejala -->
    <div class="lg:col-span-3 space-y-4">

        <!-- Header + Filter -->
        <div class="bg-white rounded-2xl border border-gray-100 p-4">
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-gray-900">{{ $symptoms->total() }} Gejala</span>
                    <span class="text-xs text-gray-400">terdaftar</span>
                </div>
                <!-- Filter Kategori -->
                <div class="flex items-center gap-2 flex-wrap">
                    @php
                        $categories = ['semua' => 'Semua', 'emosi' => '🧡 Emosi', 'perilaku' => '🟢 Perilaku', 'fisik' => '🔵 Fisik', 'kognitif' => '🟣 Kognitif', 'umum' => '⚪ Umum'];
                        $activeCategory = request('category', 'semua');
                    @endphp
                    @foreach($categories as $key => $label)
                        <a href="{{ $key === 'semua' ? route('admin.symptoms.index') : route('admin.symptoms.index', ['category' => $key]) }}"
                            class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all
                            {{ $activeCategory === $key
                                ? 'bg-indigo-600 text-white'
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Symptom Cards -->
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            @forelse($symptoms as $symptom)
                <div class="px-5 py-4 hover:bg-gray-50/80 transition-colors border-b border-gray-50 last:border-0"
                     x-data="{ expanded: false }">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <!-- Badge kode -->
                            <span class="font-mono text-xs bg-indigo-50 text-indigo-600 border border-indigo-100 px-2 py-1 rounded-lg flex-shrink-0 font-semibold">
                                {{ $symptom->code }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-semibold text-gray-900 text-sm">{{ $symptom->name }}</span>
                                    @php
                                        $catClass = ['emosi' => 'cat-emosi', 'perilaku' => 'cat-perilaku', 'fisik' => 'cat-fisik', 'kognitif' => 'cat-kognitif', 'umum' => 'cat-umum'];
                                        $catEmoji = ['emosi' => '🧡', 'perilaku' => '🟢', 'fisik' => '🔵', 'kognitif' => '🟣', 'umum' => '⚪'];
                                    @endphp
                                    <span class="category-badge {{ $catClass[$symptom->category] ?? 'cat-umum' }}">
                                        {{ $catEmoji[$symptom->category] ?? '' }} {{ $symptom->category_label ?? ucfirst($symptom->category) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $symptom->question }}</p>
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $symptom->disorders_count }} gangguan
                                    </span>
                                    <button @click="expanded = !expanded"
                                        class="text-xs text-indigo-500 hover:text-indigo-700 transition-colors">
                                        <span x-text="expanded ? 'Sembunyikan ↑' : 'Lihat detail ↓'"></span>
                                    </button>
                                </div>

                                <!-- Detail expand -->
                                <div x-show="expanded" x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-3 pt-3 border-t border-gray-100 space-y-2">
                                    <div>
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Deskripsi Klinis</span>
                                        <p class="text-xs text-gray-600 mt-0.5">{{ $symptom->description }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pertanyaan</span>
                                        <p class="text-xs text-gray-600 mt-0.5 italic">"{{ $symptom->question }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <form action="{{ route('admin.symptoms.destroy', $symptom) }}" method="POST"
                                id="delete-form-{{ $symptom->id }}">
                                @csrf @method('DELETE')
                            </form>
                            <!-- Edit -->
                            <button type="button" title="Edit"
                                onclick="openEditModal(
                                    '{{ $symptom->id }}',
                                    '{{ addslashes($symptom->code) }}',
                                    '{{ addslashes($symptom->name) }}',
                                    '{{ $symptom->category }}',
                                    '{{ addslashes($symptom->description) }}',
                                    '{{ addslashes($symptom->question) }}'
                                )"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-100 hover:text-indigo-700 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <!-- Hapus -->
                            <button type="button" title="Hapus"
                                onclick="confirmDeleteSymptom('{{ $symptom->id }}', '{{ addslashes($symptom->name) }}')"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Belum ada gejala</p>
                    <p class="text-gray-300 text-xs mt-1">Tambahkan gejala menggunakan form di sebelah kiri</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($symptoms->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $symptoms->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editSymptomModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg mx-4 z-10">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Edit Gejala</h3>
                    <p class="text-xs text-gray-400">Perbarui informasi gejala</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editSymptomForm" method="POST" class="space-y-3">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kode <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="edit_code" class="input-field text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="edit_category" class="input-field text-sm" required>
                        <option value="umum">⚪ Umum</option>
                        <option value="emosi">🧡 Emosi</option>
                        <option value="perilaku">🟢 Perilaku</option>
                        <option value="fisik">🔵 Fisik</option>
                        <option value="kognitif">🟣 Kognitif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Gejala <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit_name" class="input-field text-sm" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Klinis <span class="text-red-500">*</span></label>
                <textarea name="description" id="edit_description" rows="2" class="input-field text-sm resize-none" required></textarea>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Pertanyaan untuk User <span class="text-red-500">*</span></label>
                <textarea name="question" id="edit_question" rows="2" class="input-field text-sm resize-none" required></textarea>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteSymptomModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteSymptomModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 z-10">
        <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-2xl mx-auto mb-4">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-gray-900 text-center mb-1">Hapus Gejala?</h3>
        <p id="deleteSymptomName" class="text-indigo-700 font-semibold text-center text-sm mb-2"></p>
        <p class="text-xs text-gray-400 text-center mb-5">Gejala yang sudah dipakai di gangguan mental juga akan ikut terhapus.</p>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteSymptomModal()"
                class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button type="button" id="confirmDeleteSymptomBtn"
                class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-medium text-sm transition-colors">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openEditModal(id, code, name, category, description, question) {
        document.getElementById('edit_code').value        = code;
        document.getElementById('edit_name').value        = name;
        document.getElementById('edit_category').value   = category;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_question').value   = question;
        document.getElementById('editSymptomForm').action = `/admin/symptoms/${id}`;

        const modal = document.getElementById('editSymptomModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editSymptomModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    function confirmDeleteSymptom(id, name) {
        document.getElementById('deleteSymptomName').textContent = name;
        document.getElementById('confirmDeleteSymptomBtn').onclick = () => {
            document.getElementById('delete-form-' + id).submit();
        };
        const modal = document.getElementById('deleteSymptomModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteSymptomModal() {
        const modal = document.getElementById('deleteSymptomModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush