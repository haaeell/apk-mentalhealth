@extends('layouts.admin')
@section('title', 'Gangguan Mental')
@section('page-title', 'Manajemen Gangguan Mental')
@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-500 text-sm">Total {{ $disorders->total() }} jenis gangguan mental dalam sistem</p>
        </div>
        <a href="{{ route('admin.disorders.create') }}" class="btn-primary">
            + Tambah Gangguan
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-left text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Gangguan</th>
                    <th class="px-6 py-4">Tingkat</th>
                    <th class="px-6 py-4">Gejala</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($disorders as $disorder)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span
                                class="font-mono text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">{{ $disorder->code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $disorder->name }}</div>
                            <div class="text-xs text-gray-400">{{ Str::limit($disorder->description, 60) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge-{{ $disorder->severity_color }}">{{ $disorder->severity_label }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $disorder->symptoms_count }} gejala</td>
                        <td class="px-6 py-4">
                            <span class="{{ $disorder->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $disorder->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.disorders.edit', $disorder) }}"
                                    class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">Edit</a>
                                <form action="{{ route('admin.disorders.destroy', $disorder) }}" method="POST"
                                    onsubmit="return confirm('Hapus gangguan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $disorders->links() }}</div>
    </div>
@endsection