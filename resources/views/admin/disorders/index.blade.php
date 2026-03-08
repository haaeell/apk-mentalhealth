@extends('layouts.admin')
@section('title', 'Gangguan Mental')
@section('page-title', 'Manajemen Gangguan Mental')
@section('content')

    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Total {{ $disorders->count() }} jenis gangguan mental dalam sistem</p>
        <a href="{{ route('admin.disorders.create') }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Gangguan
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <table id="disordersTable" class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-400 uppercase tracking-wider">
                        <th class="px-4 py-3 rounded-l-xl">Foto</th>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Gangguan</th>
                        <th class="px-4 py-3">Tingkat</th>
                        <th class="px-4 py-3">Gejala</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($disorders as $disorder)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">
                                @if($disorder->image)
                                    <img src="{{ Storage::url($disorder->image) }}" alt="{{ $disorder->name }}"
                                        class="w-12 h-12 rounded-xl object-cover border border-gray-100">
                                @else
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg font-bold text-white flex-shrink-0"
                                        style="background-color: {{ $disorder->color_code ?? '#6366f1' }}">
                                        {{ substr($disorder->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="font-mono text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-lg">{{ $disorder->code }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $disorder->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($disorder->description, 55) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge-{{ $disorder->severity_color }}">{{ $disorder->severity_label }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $disorder->symptoms_count }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $disorder->is_active ? 'badge-green' : 'badge-red' }}">
                                    {{ $disorder->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.disorders.edit', $disorder) }}" title="Edit"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-800 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <!-- Hapus -->
                                    <button type="button" title="Hapus"
                                        onclick="confirmDelete('{{ $disorder->id }}', '{{ $disorder->name }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <!-- Modal Box -->
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4 z-10">
            <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-2xl mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Hapus Gangguan Mental?</h3>
            <p class="text-gray-500 text-sm text-center mb-1">Anda akan menghapus:</p>
            <p id="deleteDisorderName" class="text-indigo-700 font-semibold text-center mb-5 text-sm"></p>
            <p class="text-xs text-gray-400 text-center mb-6">Tindakan ini tidak dapat dibatalkan. Semua data terkait
                gangguan ini akan ikut terhapus.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-medium text-sm transition-colors">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#disordersTable').DataTable({
                dom: '<"flex items-center justify-between mb-4"lf>t<"flex items-center justify-between pt-4 border-t border-gray-100 mt-2"ip>',
                language: {
                    search: '',
                    searchPlaceholder: '🔍  Cari gangguan...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ gangguan',
                    infoEmpty: 'Tidak ada data',
                    zeroRecords: 'Gangguan tidak ditemukan',
                    paginate: { previous: '‹', next: '›' }
                },
                columnDefs: [
                    { orderable: false, targets: [0, 6] }
                ],
                pageLength: 10,
                order: [[1, 'asc']],
            });
        });

        function confirmDelete(id, name) {
            document.getElementById('deleteDisorderName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/disorders/${id}`;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endpush