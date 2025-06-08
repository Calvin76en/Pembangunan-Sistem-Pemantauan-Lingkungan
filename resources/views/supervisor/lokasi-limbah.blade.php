@extends('layout.mip.dash')

@section('content')
<!-- ===== Main Content Start ===== -->


<main>
  <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Lokasi Air Limbah Tambang`}">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
        <nav>
          <ol class="flex items-center gap-1.5">
            <li>
              <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="index.html">
                Home
                <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName"></li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="space-y-5 sm:space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Table -->
        <div class="px-6 mb-4">
          <div class="flex items-center justify-between w-full">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Lokasi</h3>

            <!-- Container untuk label dan datepicker -->
            <div class="flex flex-col items-end gap-1">
              <!-- Label Pilih Tanggal -->
              <label for="datetimePicker" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Pilih Tanggal
              </label>

              <!-- Form untuk tanggal -->
              <form method="GET" action="{{ route('mip-lokasi-limbah') }}">
                <input
                  id="datetimePicker"
                  name="date"
                  type="text"
                  value="{{ $selectedDate }}"
                  class="w-48 bg-white border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500"
                  readonly />
              </form>
            </div>
          </div>
        </div>

        <div class="max-w-full overflow-x-auto custom-scrollbar">
          <table class="min-w-full">
            <!-- Table header start -->
            <thead class="border-gray-100 border-y bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
              <tr>
                <th class="px-6 py-3 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex items-center gap-3">
                      <span class="block font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                        LOCATION ID
                      </span>
                    </div>
                  </div>
                </th>
                <th class="px-6 py-3 whitespace-nowrap">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    NAME LOCATION
                  </p>
                </th>
                <th class="px-6 py-3 whitespace-nowrap">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    MONITORING TYPE
                  </p>
                </th>
                <th class="px-6 py-3 whitespace-nowrap">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Keterangan
                  </p>
                </th>
                <th class="px-6 py-3 whitespace-nowrap">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    ACTIONS
                  </p>
                </th>
              </tr>
            </thead>
            <!-- Table header end -->

            <!-- Table body start -->
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              @foreach($lokasi as $location)
              @php
              $status = $statusPerLokasi[$location->location_id] ?? 'empty';
              $firstRecord = $dataByDate[$location->location_id] ?? null;
              @endphp
              <tr>
                <td class="px-6 py-3 whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400">
                      {{ $location->location_id }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="text-theme-sm mb-0.5 block font-medium text-gray-700 dark:text-gray-400">
                      {{ $location->location_name }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                  <div class="flex items-center">
                    <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                      {{ $location->monitoringType->monitoring_types }}
                    </p>
                  </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                  <div class="flex items-center">
                    <p class="
                                @if($status === 'completed') bg-success-50 text-success-600
                                @elseif($status === 'draft') bg-warning-50 text-warning-600
                                @elseif($status === 'empty') bg-gray-100 text-gray-400
                                @else bg-gray-100 text-gray-400
                                @endif
                                text-theme-xs rounded-full px-2 py-0.5 font-medium">
                      {{ ucfirst($status) }}
                    </p>
                    </p>
                  </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    @if ($firstRecord)
                    <a href="{{ route('edit.limbah', ['location_id' => $location->location_id]) }}?date={{ $selectedDate }}"
                      class="bg-warning-500 hover:bg-warning-600 px-4 py-2.5 text-sm text-white rounded-lg font-medium">
                      Edit
                    </a>
                    @else
                    <a href="{{ route('tambah.limbah') }}?location_id={{ $location->location_id }}&date={{ $selectedDate }}"
                      class="bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-sm text-white rounded-lg font-medium">
                      Add Data +
                    </a>
                    @endif
                  </div>
                </td>

              </tr>
              @endforeach
            </tbody>
            <!-- Table body end -->
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
</main>
<!-- ===== Main Content End ===== -->
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