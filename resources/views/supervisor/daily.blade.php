@extends('layout.supervisor.dash')

@php
use App\Models\Daily;
use App\Models\Approval;
use Carbon\Carbon;
@endphp

@section('content')
<div class="container p-6 max-w-7xl mx-auto">

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Notifikasi error --}}
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
            Persetujuan Laporan Harian
        </h1>
        <p class="mt-2 text-gray-600">Tinjau dan setujui laporan pemantauan lingkungan harian</p>

        {{-- Global Alert for Incomplete Data --}}
        @if(isset($locationValidation) && !$locationValidation['is_complete'])
        <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm animate-pulse">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-red-800">🚨 PERHATIAN: Data Monitoring Belum Lengkap!</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p class="font-semibold">{{ $locationValidation['total_required'] - $locationValidation['total_completed'] }} dari {{ $locationValidation['total_required'] }} lokasi belum mengisi data monitoring.</p>
                        <p class="mt-1">Approval akan diaktifkan setelah SEMUA lokasi mengisi data untuk tanggal {{ Carbon::parse($date ?? now())->format('d F Y') }}.</p>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <button onclick="showIncompleteDataAlert()"
                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Lihat Detail
                        </button>

                    </div>
                </div>
            </div>
        </div>
        @elseif(isset($locationValidation) && $locationValidation['is_complete'])
        <div class="mt-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-green-800">✅ Data Monitoring Lengkap!</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>Semua {{ $locationValidation['total_required'] }} lokasi telah mengisi data monitoring. Laporan siap untuk di-approve.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Form Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
        <form action="{{ route('approval.daily.execute') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Report Type Selection --}}
                <div>
                    <label for="report_type" class="block text-sm font-semibold text-gray-700 mb-2">
                        Monitoring Type
                    </label>
                    <div class="relative">
                        <select id="report_type" name="report_type" required
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 appearance-none bg-white">
                            <option value="" disabled selected>Pilih Tipe Pemantauan...</option>
                            @foreach($monitoringTypes as $type)
                            <option value="{{ $type->monitoring_id }}" @if(old('report_type')==$type->monitoring_id) selected @endif>
                                {{ $type->monitoring_types }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Date Selection --}}
                <div>
                    <label for="report_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        Report Date
                    </label>
                    <div class="relative">
                        <input type="date" id="report_date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                            class="block w-full pl-4 pr-12 py-3 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="button"
                                onclick="document.getElementById('report_date').showPicker?.() || document.getElementById('report_date').focus()"
                                class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                    Tampilkan Laporan Data
                </button>
            </div>
        </form>
    </div>

    {{-- Data Preview Section --}}
    @if(session()->has('reportType') && session()->has('date') && session()->has('reportId'))
    @php
    $reportType = session('reportType');
    $date = session('date');
    $reportId = session('reportId');
    $reportData = session('reportData');
    $monitoringTypeName = session('monitoringTypeName');
    $locationValidation = session('locationValidation');
    @endphp
    @endif

    @isset($reportType, $date, $reportId)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Report Header --}}
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Daily Report Details</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ Carbon::parse($date)->format('l, d F Y') }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ $monitoringTypeName }}
                    </span>

                    @php
                    $currentStatus = Daily::find($reportId)->status ?? 'pending';
                    @endphp
                    @if($currentStatus == 'approved')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Approved
                    </span>
                    @elseif($currentStatus == 'rejected')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Rejected
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Pending Review
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Location Validation Status --}}
        @if(isset($locationValidation))
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-md font-medium text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Location Completeness Status
                </h3>
                <div class="flex items-center gap-2">
                    @if($locationValidation['is_complete'])
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Complete
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Incomplete
                    </span>
                    @endif
                    <span class="text-sm font-medium text-gray-700">
                        {{ $locationValidation['total_completed'] }}/{{ $locationValidation['total_required'] }} locations
                    </span>
                </div>
            </div>

            {{-- Progress Bar --}}
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                <div class="h-2.5 rounded-full {{ $locationValidation['is_complete'] ? 'bg-green-600' : 'bg-red-500' }}"
                    style="width: {{ $locationValidation['completion_percentage'] }}%"></div>
            </div>

            {{-- Location Details --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                @foreach($locationValidation['locations'] as $location)
                <div class="flex items-center justify-between p-3 rounded-lg {{ $location['has_data'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                    <div class="flex items-center">
                        @if($location['has_data'])
                        <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        @else
                        <svg class="w-4 h-4 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        @endif
                        <span class="text-sm font-medium {{ $location['has_data'] ? 'text-green-800' : 'text-red-800' }}">
                            {{ $location['location_name'] }}
                        </span>
                    </div>
                    @if($location['has_data'])
                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded">
                        {{ $location['data_count'] }} records
                    </span>
                    @else
                    <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded">
                        No data
                    </span>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Warning Message if Incomplete --}}
            @if(!$locationValidation['is_complete'])
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">⚠️ PERINGATAN: DATA MONITORING BELUM LENGKAP!</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p class="font-semibold">SEMUA LOKASI HARUS MENGISI DATA MONITORING SEBELUM APPROVAL!</p>
                            <p class="mt-1">Laporan tidak dapat di-approve sampai seluruh lokasi telah mengumpulkan data monitoring untuk tanggal {{ Carbon::parse($date ?? now())->format('d F Y') }}.</p>
                            <p class="mt-2"><strong>Status saat ini:</strong> {{ $locationValidation['completion_percentage'] }}% complete ({{ $locationValidation['total_completed'] }} dari {{ $locationValidation['total_required'] }} lokasi)</p>

                            @php
                            $missingLocations = collect($locationValidation['locations'])->where('has_data', false);
                            @endphp

                            @if($missingLocations->count() > 0)
                            <p class="mt-2"><strong>Lokasi yang belum mengisi:</strong></p>
                            <ul class="list-disc list-inside mt-1 text-xs">
                                @foreach($missingLocations->take(5) as $location)
                                <li>{{ $location['location_name'] }}</li>
                                @endforeach
                                @if($missingLocations->count() > 5)
                                <li>... dan {{ $missingLocations->count() - 5 }} lokasi lainnya</li>
                                @endif
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">💡 Langkah Penyelesaian</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>1. Hubungi tim MIP untuk melengkapi data monitoring</p>
                            <p>2. Pastikan semua lokasi mengisi data untuk tanggal yang dipilih</p>
                            <p>3. Refresh halaman untuk melihat update status</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">✅ DATA LENGKAP - SIAP UNTUK APPROVAL</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Semua lokasi telah mengisi data monitoring. Laporan dapat di-approve.</p>
                            <p><strong>Status:</strong> {{ $locationValidation['total_completed'] }}/{{ $locationValidation['total_required'] }} lokasi ({{ $locationValidation['completion_percentage'] }}%)</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Data Table --}}
        @if(isset($reportData) && $reportData->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($reportData->first() as $key => $value)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                            {{ str_replace('_', ' ', $key) }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reportData as $index => $row)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        @foreach($row as $key => $value)
                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $key == 'Lokasi' ? 'font-medium text-gray-900' : 'text-gray-600' }}">
                            @if($value === null || $value === '')
                            <span class="text-gray-400 italic">-</span>
                            @else
                            {{ $value }}
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Table Summary --}}
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <span>Total {{ $reportData->count() }} records</span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Scroll horizontally to see all columns
                </span>
            </div>
        </div>

        {{-- Action Section --}}
        @php
        $reportStatus = Daily::find($reportId)->status ?? 'pending';
        $canApprove = isset($locationValidation) ? $locationValidation['is_complete'] : false;
        @endphp

        <div class="p-6 bg-gray-50 border-t border-gray-200">
            @if($reportStatus == 'approved')
            {{-- Already Approved State --}}
            <div class="flex items-center justify-center">
                <div class="bg-green-50 rounded-lg p-6 max-w-md w-full text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-green-900 mb-2">Report Approved</h3>
                    <p class="text-sm text-green-700">This daily report has been successfully approved and signed.</p>

                    @php
                    $approvalInfo = Approval::where('daily_report_id', $reportId)
                    ->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->first();
                    @endphp
                    @if($approvalInfo)
                    <p class="text-xs text-green-600 mt-3">
                        Approved by {{ $approvalInfo->approval_name }} • {{ Carbon::parse($approvalInfo->approval_date)->format('d M Y, H:i') }}
                    </p>
                    @endif
                </div>
            </div>
            @else
            {{-- Pending/Rejected State --}}
            @if($reportStatus == 'rejected')
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-amber-800">Previously Rejected Report</h3>
                            @php
                            $rejectionInfo = Approval::where('daily_report_id', $reportId)
                            ->where('status', 'rejected')
                            ->orderBy('created_at', 'desc')
                            ->first();
                            @endphp
                            @if($rejectionInfo && $rejectionInfo->notes)
                            <div class="mt-2 text-sm text-amber-700">
                                <p><strong>Reason:</strong> {{ $rejectionInfo->notes }}</p>
                                <p class="text-xs mt-1">By {{ $rejectionInfo->approval_name }} • {{ Carbon::parse($rejectionInfo->approval_date)->format('d M Y, H:i') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="showApprovalModal('reject')"
                    class="inline-flex items-center justify-center px-6 py-3 border border-red-300 text-red-700 font-medium rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reject Report
                </button>

                @if($canApprove)
                <button onclick="showApprovalModal('approve')"
                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Approve Report
                </button>
                @else
                <button onclick="showIncompleteDataAlert()"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed hover:bg-gray-400 transition-all duration-200"
                    title="Cannot approve - incomplete location data">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m8-11V5a2 2 0 00-2-2H8a2 2 0 00-2 2v1m4 0V4a1 1 0 011-1h2a1 1 0 011 1v2m-4 0h4" />
                    </svg>
                    Approve Report (Disabled)
                </button>
                @endif
            </div>

            {{-- Disabled State Message --}}
            @if(!$canApprove && isset($locationValidation))
            <div class="mt-4 text-center">
                <div class="inline-flex items-center px-4 py-2 bg-red-100 border border-red-300 rounded-lg">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m8-11V5a2 2 0 00-2-2H8a2 2 0 00-2 2v1m4 0V4a1 1 0 011-1h2a1 1 0 011 1v2m-4 0h4" />
                    </svg>
                    <div class="text-sm">
                        <p class="font-medium text-red-800">🚫 APPROVAL DINONAKTIFKAN</p>
                        <p class="text-red-700">{{ $locationValidation['total_required'] - $locationValidation['total_completed'] }} lokasi masih perlu mengisi data monitoring</p>
                    </div>
                </div>
                <button onclick="showIncompleteDataAlert()"
                    class="mt-2 text-sm text-blue-600 hover:text-blue-800 underline focus:outline-none">
                    Klik untuk detail lokasi yang belum mengisi →
                </button>
            </div>
            @endif
            @endif
        </div>
        @else
        {{-- No Data State --}}
        <div class="p-12">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No data found</h3>
                <p class="mt-1 text-sm text-gray-500">No monitoring data available for the selected date and type.</p>
            </div>
        </div>
        @endif
    </div>
    @endisset

    {{-- SIMPLIFIED Incomplete Data Alert Modal --}}
    <div id="incompleteDataModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full">
            {{-- Simple Header --}}
            <div class="flex items-center justify-between p-4 border-b">
                <div class="flex items-center">
                    <span class="text-xl mr-2">⚠️</span>
                    <h3 class="font-semibold text-gray-900">Cannot Approve Report</h3>
                </div>
                <button onclick="hideIncompleteDataAlert()" class="text-gray-400 hover:text-gray-600 text-xl">
                    ✕
                </button>
            </div>

            {{-- Simple Content --}}
            <div class="p-4">
                <p class="text-sm text-gray-700 mb-3">
                    Data monitoring belum lengkap
                </p>

                @if(isset($locationValidation))
                {{-- Progress Info --}}
                <div class="bg-gray-50 rounded p-3 mb-3">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Persyaratan Approval</span>
                        <span class="font-medium">{{ $locationValidation['total_completed'] }}/{{ $locationValidation['total_required'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded h-2">
                        <div class="bg-red-500 rounded h-2" style="width: {{ $locationValidation['completion_percentage'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">
                        SEMUA LOKASI HARUS MENGISI DATA MONITORING!
                    </p>
                </div>

                {{-- Steps --}}
                <div class="text-sm text-gray-600">
                    <p class="font-medium mb-1">Langkah Selanjutnya:</p>
                    <ol class="list-decimal list-inside space-y-1 text-xs">
                        <li>Hubungi tim MIP untuk melengkapi data monitoring</li>
                        <li>Pastikan semua lokasi telah mengisi data untuk tanggal {{ Carbon::parse($date ?? now())->format('d F Y') }}</li>
                        <li>Refresh halaman atau generate laporan ulang untuk melihat update data</li>
                        <li>Approval akan tersedia setelah semua data lengkap</li>
                    </ol>
                </div>
                @endif
            </div>

            {{-- Simple Actions --}}
            <div class="flex gap-2 p-4 bg-gray-50 rounded-b-lg">
                <button onclick="hideIncompleteDataAlert()"
                    class="flex-1 py-2 px-3 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100">
                    Tutup
                </button>

            </div>
        </div>
    </div>

    {{-- Approval Modal --}}
    <div id="approvalModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modalTitle" class="text-lg font-medium text-gray-900 flex items-center"></h3>
                    <button onclick="hideApprovalModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="approvalForm" action="{{ route('approval.daily.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $reportId ?? '' }}" />
                    <input type="hidden" id="actionType" name="action" value="" />

                    <div class="mb-4">
                        <label for="approval_comment" class="block text-sm font-medium text-gray-700 mb-2">
                            <span id="commentLabel">Comment</span>
                            <span id="commentRequired" class="text-red-500">*</span>
                        </label>
                        <textarea id="approval_comment" name="comment" rows="4"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="Enter your comment..."></textarea>
                        <p id="commentHint" class="mt-1 text-xs text-gray-500 hidden">Optional: Add any additional notes</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="hideApprovalModal()"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit" id="confirmButton"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Signature Form Modal --}}
    @if(session('showSignatureForm') && session('reportId'))
    @php
    $reportId = session('reportId');
    $showSignatureForm = true;
    @endphp
    @endif

    @isset($reportId, $showSignatureForm)
    @if($showSignatureForm)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Digital Signature Required
                </h3>
                <p class="text-sm text-gray-500 mt-1">Complete the approval process with your signature</p>
            </div>

            <form action="{{ route('approval.daily.save_signature') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="report_id" value="{{ $reportId }}" />

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="signature_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="signature_name" name="name" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="Enter your full name" />
                        </div>

                        <div>
                            <label for="signature_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="signature_date" name="date" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" />
                        </div>
                    </div>

                    <div>
                        <label for="company_position" class="block text-sm font-medium text-gray-700 mb-2">
                            Position/Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="company_position" name="company_position" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="e.g., Environmental Supervisor" />
                    </div>

                    <div>
                        <label for="signature_data" class="block text-sm font-medium text-gray-700 mb-2">
                            Signature Data <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea id="signature_data" name="signature_data" rows="4" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm font-mono text-xs"
                                placeholder="Paste Base64 signature or image URL..."></textarea>
                            <button type="button" onclick="openSignaturePad()"
                                class="absolute top-2 right-2 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded hover:bg-blue-200 transition-colors">
                                Draw Signature
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="window.location.reload()"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Save Signature
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @endisset

</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f3f4f6;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>

<script>
    // Show incomplete data alert modal - SIMPLIFIED
    function showIncompleteDataAlert() {
        const modal = document.getElementById('incompleteDataModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Hide incomplete data alert modal
    function hideIncompleteDataAlert() {
        const modal = document.getElementById('incompleteDataModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function showApprovalModal(action) {
        // Check if approval is allowed
        @if(isset($canApprove) && !$canApprove)
        if (action === 'approve') {
            showIncompleteDataAlert();
            return;
        }
        @endif

        const modal = document.getElementById('approvalModal');
        const title = document.getElementById('modalTitle');
        const actionInput = document.getElementById('actionType');
        const confirmButton = document.getElementById('confirmButton');
        const commentTextarea = document.getElementById('approval_comment');
        const commentRequired = document.getElementById('commentRequired');
        const commentHint = document.getElementById('commentHint');
        const commentLabel = document.getElementById('commentLabel');

        if (action === 'approve') {
            title.innerHTML = `
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Approve Daily Report
        `;
            confirmButton.className = 'flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500';
            confirmButton.textContent = 'Approve';

            commentTextarea.removeAttribute('required');
            commentRequired.classList.add('hidden');
            commentHint.classList.remove('hidden');
            commentLabel.textContent = 'Comment (Optional)';
            commentTextarea.placeholder = 'Add any additional notes...';
        } else {
            title.innerHTML = `
            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Reject Daily Report
        `;
            confirmButton.className = 'flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500';
            confirmButton.textContent = 'Reject';

            commentTextarea.setAttribute('required', 'required');
            commentRequired.classList.remove('hidden');
            commentHint.classList.add('hidden');
            commentLabel.textContent = 'Reason for Rejection';
            commentTextarea.placeholder = 'Please provide a reason for rejection...';
        }

        actionInput.value = action;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function hideApprovalModal() {
        const modal = document.getElementById('approvalModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('approval_comment').value = '';
    }

    function openSignaturePad() {
        // SIMPLIFIED alert
        alert('Fitur signature pad belum tersedia.');
    }

    // Modal close on outside click
    document.getElementById('approvalModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideApprovalModal();
        }
    });

    // Modal close on outside click for incomplete data modal
    document.getElementById('incompleteDataModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideIncompleteDataAlert();
        }
    });

    // Auto-set current date
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('signature_date');
        if (dateInput && !dateInput.value) {
            dateInput.value = new Date().toISOString().split('T')[0];
        }

        // Form submit loading state
        const form = document.querySelector('form[action*="execute"]');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
            `;
                submitBtn.disabled = true;
            });
        }

        // Form validation
        const approvalForm = document.getElementById('approvalForm');
        if (approvalForm) {
            approvalForm.addEventListener('submit', function(e) {
                const action = document.getElementById('actionType').value;
                const comment = document.getElementById('approval_comment').value.trim();

                if (action === 'reject' && !comment) {
                    e.preventDefault();
                    document.getElementById('approval_comment').focus();
                    document.getElementById('approval_comment').classList.add('ring-2', 'ring-red-500');
                    setTimeout(() => {
                        document.getElementById('approval_comment').classList.remove('ring-2', 'ring-red-500');
                    }, 3000);
                }
            });
        }

        // Show completion status alert on page load if data is incomplete
        @if(isset($locationValidation) && !$locationValidation['is_complete'])
        setTimeout(function() {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 z-50 bg-amber-100 border-l-4 border-amber-500 p-4 rounded-r-lg shadow-lg max-w-sm animate-fade-in';
            toast.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-amber-800">Data Belum Lengkap!</p>
                    <p class="text-xs text-amber-700 mt-1">{{ $locationValidation['total_required'] - $locationValidation['total_completed'] }} lokasi belum mengisi data monitoring</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-amber-500 hover:text-amber-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;
            document.body.appendChild(toast);

            // Auto remove after 8 seconds
            setTimeout(() => {
                toast.remove();
            }, 8000);
        }, 1000);
        @endif
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC key to close modals
        if (e.key === 'Escape') {
            hideApprovalModal();
            hideIncompleteDataAlert();
        }
    });
</script>

@endsection