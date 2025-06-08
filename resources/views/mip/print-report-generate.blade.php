@extends('layout.mip.dash')

@section('content')
<main class="p-6 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Print Report - {{ strtoupper($reportType) }} Report</h1>
    <p>Periode: {{ $periodType === 'month' ? \Carbon\Carbon::createFromFormat('m', $periodValue)->format('F') : $periodValue }}</p>

    <button onclick="window.print()" class="mb-4 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Print this page
    </button>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-3 py-2">Tanggal</th>
                <th class="border border-gray-300 px-3 py-2">Lokasi ID</th>
                @if($reportType === 'ph')
                    <th class="border border-gray-300 px-3 py-2">pH Inlet</th>
                    <th class="border border-gray-300 px-3 py-2">pH Outlet 1</th>
                    <th class="border border-gray-300 px-3 py-2">pH Outlet 2</th>
                @elseif($reportType === 'debit')
                    <th class="border border-gray-300 px-3 py-2">Debit</th>
                @elseif($reportType === 'tss')
                    <th class="border border-gray-300 px-3 py-2">TSS Inlet</th>
                    <th class="border border-gray-300 px-3 py-2">TSS Outlet</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="border border-gray-300 px-3 py-1">{{ $item->created_at->format('Y-m-d') }}</td>
                    <td class="border border-gray-300 px-3 py-1">{{ $item->location_id }}</td>
                    @if($reportType === 'ph')
                        <td class="border border-gray-300 px-3 py-1">{{ $item->ph_inlet }}</td>
                        <td class="border border-gray-300 px-3 py-1">{{ $item->ph_outlet_1 }}</td>
                        <td class="border border-gray-300 px-3 py-1">{{ $item->ph_outlet_2 }}</td>
                    @elseif($reportType === 'debit')
                        <td class="border border-gray-300 px-3 py-1">{{ $item->debit }}</td>
                    @elseif($reportType === 'tss')
                        <td class="border border-gray-300 px-3 py-1">{{ $item->tss_inlet }}</td>
                        <td class="border border-gray-300 px-3 py-1">{{ $item->tss_outlet }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border border-gray-300 text-center py-4">Tidak ada data untuk periode dan tipe laporan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</main>
@endsection
