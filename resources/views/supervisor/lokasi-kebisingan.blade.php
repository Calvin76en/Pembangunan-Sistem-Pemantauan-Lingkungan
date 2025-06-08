@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Lokasi Pengukuran Kebisingan`}">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2
          class="text-xl font-semibold text-gray-800 dark:text-white/90"
          x-text="pageName"></h2>
        <nav>
          <ol class="flex items-center gap-1.5">
            <li>
              <a
                class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                href="index.html">
                Home
                <svg
                  class="stroke-current"
                  width="17"
                  height="16"
                  viewBox="0 0 17 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                    stroke=""
                    stroke-width="1.2"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </li>
            <li
              class="text-sm text-gray-800 dark:text-white/90"
              x-text="pageName"></li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="space-y-5 sm:space-y-6">
      <div
        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <!-- Filter Section -->
        <div class="flex flex-col gap-5 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
              Lokasi Monitoring Kebisingan
            </h3>
          </div>
          <form method="GET" action="{{ route('lokasi-kebisingan') }}" class="mb-4">
            <input
              id="datetimePicker"
              name="date"
              type="text"
              value="{{ $selectedDate }}"
              class="w-48 bg-white border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500"
              readonly />
          </form>
        </div>

        <!-- Card Grid Layout -->
        <div class="p-6 pt-0">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lokasi_monitoring_kebisingan as $lokasi)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300">
              <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                  <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                      {{ $lokasi->location_name }}
                    </h3>
                    
                    <!-- Location ID -->
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                      ID: {{ $lokasi->location_id }}
                    </p>
                    
                    <!-- Monitoring Type -->
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                      <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                        </svg>
                        {{ $lokasi->monitoringType->monitoring_types ?? $lokasi->monitoring_type_name ?? 'Monitoring Kebisingan' }}
                      </span>
                    </p>

                    <!-- Status Badge -->
                    @php
                    $status = $statusPerLokasi[$lokasi->location_id] ?? 'empty';
                    $badgeClass = match($status) {
                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                        'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                    };
                    $statusText = match($status) {
                        'completed' => 'Lengkap',
                        'draft' => 'Draft',
                        default => 'Belum Ada Data'
                    };
                    @endphp
                    
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                      {{ $statusText }}
                    </div>
                  </div>
                </div>

                <div class="flex gap-3">
                  <!-- Input/Edit Button -->
                  @if($status === 'empty')
                  <a href="{{ route('tambah.kebisingan', [
                              'location_id' => $lokasi->location_id,
                              'location_name' => $lokasi->location_name,
                              'monitoring_type' => $lokasi->monitoringType->monitoring_types ?? 'Monitoring Kebisingan',
                              'monitoring_id' => $lokasi->monitoringType->monitoring_id ?? $lokasi->monitoring_id,
                              'date' => $selectedDate
                          ]) }}"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Input Data
                  </a>
                  @else
                  <a href="{{ route('edit.kebisingan', [
                              'location_id' => $lokasi->location_id,
                              'location_name' => $lokasi->location_name,
                              'monitoring_type' => $lokasi->monitoringType->monitoring_types ?? 'Monitoring Kebisingan',
                              'monitoring_id' => $lokasi->monitoringType->monitoring_id ?? $lokasi->monitoring_id,
                              'date' => $selectedDate
                          ]) }}"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Edit Data
                  </a>
                  @endif

                  <!-- Detail Button -->
                  <a href="#" onclick="showDetail('{{ $lokasi->location_id }}', '{{ $selectedDate }}')"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
            @endforeach
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

  // Function to show detail modal/popup
  function showDetail(locationId, date) {
    // Implementasi untuk menampilkan detail data
    console.log('Show detail for location:', locationId, 'date:', date);
    // Anda bisa menambahkan modal atau redirect ke halaman detail
  }
</script>
@endpush