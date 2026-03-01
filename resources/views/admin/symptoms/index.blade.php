@extends('layouts.admin')
@section('title', 'Manajemen Gejala')
@section('page-title', 'Manajemen Gejala')
@section('content')

    <div class="grid lg:grid-cols-5 gap-6">
        <!-- Form Tambah -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-20">
                <h3 class="font-bold text-gray-900 mb-4">Tambah Gejala Baru</h3>
                <form action="{{ route('admin.symptoms.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kode Gejala <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="code" class="input-field text-sm" placeholder="G001" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Gejala <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kategori <span
                                class="text-red-500">*</span></label>
                        <select name="category" class="input-field text-sm" required>
                            <option value="umum">Umum</option>
                            <option value="emosi">Emosi</option>
                            <option value="perilaku">Perilaku</option>
                            <option value="fisik">Fisik</option>
                            <option value="kognitif">Kognitif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Klinis <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" rows="2" class="input-field text-sm resize-none" required></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Pertanyaan untuk User <span
                                class="text-red-500">*</span></label>
                        <textarea name="question" rows="2" class="input-field text-sm resize-none"
                            placeholder="Apakah Anda..." required></textarea>
                    </div>
                    <button type="submit" class="w-full btn-primary justify-center">Tambah Gejala</button>
                </form>
            </div>
        </div>

        <!-- List -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <span class="font-bold text-gray-900">{{ $symptoms->total() }} Gejala</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($symptoms as $symptom)
                        <div class="px-5 py-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <span
                                        class="font-mono text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded flex-shrink-0">{{ $symptom->code }}</span>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm">{{ $symptom->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $symptom->category_label }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($symptom->question, 80) }}</div>
                                        <div class="text-xs text-gray-400">Digunakan di {{ $symptom->disorders_count }} gangguan
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <form action="{{ route('admin.symptoms.destroy', $symptom) }}" method="POST"
                                        onsubmit="return confirm('Hapus gejala ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-400 hover:text-red-600 text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-5 py-4 border-t border-gray-100">{{ $symptoms->links() }}</div>
            </div>
        </div>
    </div>
@endsection