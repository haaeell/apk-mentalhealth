@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label' => 'Total Pengguna', 'value' => $totalUsers, 'color' => 'indigo', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
        ['label' => 'Total Diagnosa', 'value' => $totalDiagnoses, 'color' => 'purple', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'Jenis Gangguan', 'value' => $totalDisorders, 'color' => 'blue', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18'],
        ['label' => 'Total Gejala', 'value' => $totalSymptoms, 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ] as $stat)
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-{{ $stat['color'] }}-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
        </div>
        <div class="text-2xl font-extrabold text-gray-900">{{ number_format($stat['value']) }}</div>
        <div class="text-sm text-gray-500 mt-0.5">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <!-- Chart Diagnosa per Bulan -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4">Diagnosa per Bulan (6 Bulan Terakhir)</h3>
        <canvas id="monthlyChart" height="200"></canvas>
    </div>

    <!-- Top Disorders -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4">Top 5 Gangguan Terdiagnosa</h3>
        <div class="space-y-3">
            @foreach($topDisorders as $i => $disorder)
            <div class="flex items-center space-x-3">
                <div class="text-sm font-bold text-gray-400 w-6">{{ $i + 1 }}</div>
                <div class="flex-1">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-700">{{ $disorder->name }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $disorder->diagnosis_count }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        @php $maxCount = $topDisorders->first()->diagnosis_count ?: 1; @endphp
                        <div class="bg-indigo-500 h-1.5 rounded-full"
                             style="width: {{ ($disorder->diagnosis_count / $maxCount) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Severity Distribution -->
<div class="grid lg:grid-cols-3 gap-4 mb-6">
    @foreach([['ringan', 'Ringan', 'green', '😊'], ['sedang', 'Sedang', 'yellow', '😐'], ['berat', 'Berat', 'red', '😰']] as $s)
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center space-x-3 mb-2">
            <span class="text-2xl">{{ $s[3] }}</span>
            <div>
                <div class="font-bold text-gray-900 text-xl">{{ $severityStats[$s[0]] }}</div>
                <div class="text-sm text-gray-500">Diagnosa Tingkat {{ $s[1] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Recent Diagnoses Table -->
<div class="bg-white rounded-2xl border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-900">Diagnosa Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                    <th class="pb-3 pr-4">Pengguna</th>
                    <th class="pb-3 pr-4">Gangguan Terdeteksi</th>
                    <th class="pb-3 pr-4">Tingkat</th>
                    <th class="pb-3 pr-4">CF</th>
                    <th class="pb-3">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($recentDiagnoses as $d)
                <tr>
                    <td class="py-3 pr-4">
                        <div class="font-medium text-gray-900">{{ $d->user->name }}</div>
                        <div class="text-gray-400 text-xs">{{ $d->user->email }}</div>
                    </td>
                    <td class="py-3 pr-4">
                        <span class="font-medium text-gray-700">{{ $d->primaryDisorder->name ?? '-' }}</span>
                    </td>
                    <td class="py-3 pr-4">
                        @if($d->primaryDisorder)
                        <span class="badge-{{ $d->primaryDisorder->severity_color }}">{{ $d->primaryDisorder->severity_label }}</span>
                        @else <span class="text-gray-400">-</span> @endif
                    </td>
                    <td class="py-3 pr-4">
                        <span class="font-bold text-indigo-600">{{ $d->cf_percentage }}%</span>
                    </td>
                    <td class="py-3 text-gray-400 text-xs">{{ $d->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($monthlyData, 'month')) !!},
        datasets: [{
            label: 'Jumlah Diagnosa',
            data: {!! json_encode(array_column($monthlyData, 'count')) !!},
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#6366f1',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endsection