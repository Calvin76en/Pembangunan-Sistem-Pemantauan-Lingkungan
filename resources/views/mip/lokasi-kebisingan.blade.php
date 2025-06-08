@extends('layout.mip.dash')

@section('content')
<main>
  <div class="mx-auto max-w-7xl p-6">
    <!-- Breadcrumb -->
    <div x-data="{ pageName: `Lokasi Pengukuran Kebisingan`}">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
        <nav>
          <ol class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
            <li>
              <a href="index.html" class="inline-flex items-center gap-1.5 hover:underline transition-colors">
                Home
                <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
            </li>
            <li class="text-gray-800 dark:text-white/90" x-text="pageName"></li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
      <!-- Header dengan Date Picker -->
      <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Daftar Lokasi Monitoring</h3>
            <p class="text-gray-600 dark:text-gray-400">Total {{ count($lokasi_monitoring_kebisingan) }} lokasi </p>
          </div>

          <!-- Date Picker -->
          <form method="GET" action="{{ route('lokasi-kebisingan') }}" class="flex items-center">
            <div class="relative">
              <label class="sr-only">Pilih Tanggal</label>
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <input
                id="datetimePicker"
                name="date"
                type="date"
                value="{{ $selectedDate }}"
                class="pl-10 pr-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-sm font-medium
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                hover:border-gray-400 transition-colors duration-200 w-48"
                onchange="this.form.submit()" />
            </div>
          </form>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <!-- Table Header -->
          <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
              <th class="px-8 py-4 text-left">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                  Lokasi
                </span>
              </th>
              <th class="px-8 py-4 text-left">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                  Jenis Monitoring
                </span>
              </th>
              <th class="px-8 py-4 text-center">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                  Status
                </span>
              </th>
              <th class="px-8 py-4 text-center">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                  Aksi
                </span>
              </th>
            </tr>
          </thead>

          <!-- Table Body -->
          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($lokasi_monitoring_kebisingan as $index => $location)
            @php
            $status = $statusPerLokasi[$location->location_id] ?? 'empty';
            @endphp
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
              <!-- Lokasi -->
              <td class="px-8 py-6">
                <div class="flex items-center">
                  <!-- <div>
                    <span class="text-black font-bold text-sm">{{ $index + 1 }}</span>
                  </div> -->
                  <div class="ml-4">
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                      {{ $location->location_name }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Monitoring Type -->
              <td class="px-8 py-6">
                <div class="flex items-center">
                  <span class="text-gray-900 dark:text-white font-medium">
                    {{ $location->monitoringType->monitoring_types }}
                  </span>
                </div>
              </td>

              <!-- Status -->
              <td class="px-8 py-6 text-center">
                @if($status === 'completed')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                  </svg>
                  Completed
                </span>
                @elseif($status === 'draft')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  Draft
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                  </svg>
                  Empty
                </span>
                @endif
              </td>

              <!-- Actions -->
              <td class="px-8 py-6 text-center">
                @if($status === 'completed' || $status === 'draft')
                <a href="{{ route('edit.kebisingan', [
                            'location_id' => $location->location_id,
                            'location_name' => $location->location_name,
                            'monitoring_type' => $location->monitoringType->monitoring_types,
                            'monitoring_id' => $location->monitoringType->monitoring_id,
                            'date' => $selectedDate
                          ]) }}"
                  class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 
       hover:from-yellow-600 hover:to-yellow-700 text-white font-medium text-sm rounded-lg shadow 
       transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                  <!-- Ikon pensil untuk edit -->
                  <svg class="w-3.5 h-3.5 mr-1.5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Edit Data
                </a>
                @else
                <a href="{{ route('tambah.kebisingan', [
                            'location_id' => $location->location_id,
                            'location_name' => $location->location_name,
                            'monitoring_type' => $location->monitoringType->monitoring_types,
                            'monitoring_id' => $location->monitoringType->monitoring_id,
                            'date' => $selectedDate     
                          ]) }}"
                  class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 
       hover:from-blue-600 hover:to-blue-700 text-white font-medium text-sm rounded-lg shadow 
       transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                  <svg class="w-3.5 h-3.5 mr-1.5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                  </svg>
                  Tambah Data
                </a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Footer Summary -->
      <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Total {{ count($lokasi_monitoring_kebisingan) }} lokasi monitoring
          </div>

          <div class="flex items-center gap-6 text-sm">
            @php
            $completedCount = array_count_values($statusPerLokasi)['completed'] ?? 0;
            $draftCount = array_count_values($statusPerLokasi)['draft'] ?? 0;
            $emptyCount = array_count_values($statusPerLokasi)['empty'] ?? 0;
            @endphp

            <div class="flex items-center">
              <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
              <span class="text-gray-600 dark:text-gray-400">{{ $completedCount }} Completed</span>
            </div>
            <div class="flex items-center">
              <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
              <span class="text-gray-600 dark:text-gray-400">{{ $draftCount }} Draft</span>
            </div>
            <div class="flex items-center">
              <div class="w-3 h-3 bg-gray-400 rounded-full mr-2"></div>
              <span class="text-gray-600 dark:text-gray-400">{{ $emptyCount }} Empty</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#datetimePicker", {
      enableTime: false,
      dateFormat: "Y-m-d",
      defaultDate: "{{ $selectedDate }}",
      onChange: function(selectedDates, dateStr) {
        document.querySelector('#datetimePicker').closest('form').submit();
      }
    });
  });
</script>
@endpush