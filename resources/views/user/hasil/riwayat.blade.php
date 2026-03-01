@extends('layouts.user')
@section('title', 'Riwayat Diagnosa')
@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Diagnosa</h1>

        @if($diagnoses->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                <div class="text-5xl mb-4">📋</div>
                <h3 class="font-bold text-gray-700 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-400 text-sm mb-4">Mulai diagnosa pertama Anda untuk melihat hasilnya di sini.</p>
                <a href="{{ route('user.diagnosa') }}" class="btn-primary">Mulai Diagnosa</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($diagnoses as $d)
                    <a href="{{ route('user.hasil', $d->id) }}"
                        class="block bg-white rounded-2xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl bg-indigo-50">🧠</div>
                                <div>
                                    <h3 class="font-bold text-gray-900">
                                        {{ $d->primaryDisorder->name ?? 'Tidak Terdeteksi Gangguan' }}</h3>
                                    <p class="text-sm text-gray-400">{{ $d->created_at->format('d M Y, H:i') }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        @if($d->primaryDisorder)
                                            <span
                                                class="badge-{{ $d->primaryDisorder->severity_color }} text-xs">{{ $d->primaryDisorder->severity_label }}</span>
                                        @endif
                                        <span class="text-xs text-gray-400">{{ count($d->answers ?? []) }} gejala dianalisa</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-extrabold text-indigo-600">{{ $d->cf_percentage }}%</div>
                                <div class="text-xs text-gray-400">CF</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">{{ $diagnoses->links() }}</div>
        @endif
    </div>
@endsection