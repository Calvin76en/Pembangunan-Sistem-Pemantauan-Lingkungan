  @extends('layout.mip.dash')

  @section('content')

  <!-- ===== Main Content Start ===== -->
  <main>
    <div class="mx-auto max-w-7xl p-6">
      <!-- Breadcrumb Start -->
      <div x-data="{ pageName: `Print Report`}">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
          <nav>
            <ol class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
              <li>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 hover:underline transition-colors">
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

      <!-- Main Form Card -->
      <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <form id="printReportForm" method="GET" action="{{ route('print.report.generate') }}" onsubmit="return handleFormSubmit(event)">

          <!-- Form Header -->
          <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div>
                  <h3 class="text-xl font-bold text-gray-900 dark:text-white">Buat Laporan</h3>
                  <p class="text-gray-600 dark:text-gray-400">Pilih tipe analisis Air Limbah Tambang untuk dicetak</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Body -->
          <div class="px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

              <!-- Report Type -->
              <div>
                <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                  Tipe Analisis <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <select id="report_type" name="report_type" required
                    class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all duration-200 hover:border-gray-400">
                    <option value="">Pilih Tipe Analisis</option>
                    @isset($reportTypes)
                    @foreach($reportTypes as $type)
                    <option value="{{ $type->id }}" {{ request('report_type') == $type->id ? 'selected' : '' }}>
                      {{ $type->name }}
                    </option>
                    @endforeach
                    @endisset
                  </select>
                </div>
              </div>

              <!-- Month Selection -->
              <div>
                <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                  Pilih Bulan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z" />
                    </svg>
                  </div>
                  <select id="month_value" name="month_value" required
                    class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all duration-200 hover:border-gray-400">
                    <!-- Populated by JavaScript -->
                  </select>
                </div>
              </div>

              <!-- Year Selection -->
              <div>
                <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                  Pilih Tahun <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                    </svg>
                  </div>
                  <select id="year_value" name="year_value" required
                    class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all duration-200 hover:border-gray-400">
                    <!-- Populated by JavaScript -->
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Footer -->
          <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-center">
              <button id="searchBtn" type="submit"
                class="inline-flex items-center px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                </svg>
                Buat Laporan
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Alert for No Data -->
      @if(isset($message))
      <div class="mb-8 rounded-xl border-l-4 border-amber-500 bg-red-50 px-6 py-4 shadow-sm dark:bg-red-950/30 dark:border-red-500 dark:text-red-100" id="noDataAlert">
        <div class="flex items-start space-x-3">
          <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 19c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <div class="flex-1">
            <h3 class="text-sm font-semibold text-amber-700 dark:text-amber-200">
              Data Tidak Ditemukan
            </h3>
            <p class="text-sm text-amber-600 dark:text-amber-300 mt-1">
              {{ $message }}
            </p>
          </div>
          <button onclick="document.getElementById('noDataAlert').style.display='none'"
            class="flex-shrink-0 text-amber-500 hover:text-amber-700 transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
      @endif

      <!-- Results Section -->
      @if(isset($data) && $data->count() > 0)
      <div class="print-section bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Results Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Laporan {{ $reportTypeName ?? 'Monitoring' }}</h3>
                <p class="text-gray-600 dark:text-gray-400">
                  {{ $data->count() }} data • Periode: {{ isset($month) && isset($year) ? \Carbon\Carbon::createFromFormat('m-Y', $month.'-'.$year)->format('F Y') : '' }}
                </p>
                @if(isset($approvalInfo))
                <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                  <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  Approved by {{ $approvalInfo->approval_name }} • {{ \Carbon\Carbon::parse($approvalInfo->approval_date)->format('d M Y') }}
                </p>
                @endif
              </div>
            </div>

            <!-- Print Button -->
            <button onclick="window.print()"
              class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2 no-print">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18,3H6V7H18M19,12A1,1 0 0,1 18,11A1,1 0 0,1 19,10A1,1 0 0,1 20,11A1,1 0 0,1 19,12M16,19H8V14H16M19,8H5A3,3 0 0,0 2,11V17H6V21H18V17H22V11A3,3 0 0,0 19,8Z" />
              </svg>
              Cetak Laporan
            </button>
          </div>
        </div>

        <!-- Results Table -->
        <div class="p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full">
              <thead>
                <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">No.</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Tanggal</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Lokasi</th>

                  @if(isset($reportType))
                  @switch($reportType)
                  @case('ph') {{-- pH Analysis --}}
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">pH Inlet</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">pH Outlet 1</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">pH Outlet 2</th>
                  @break
                  @case('debit') {{-- Debit Analysis --}}
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Debit (m³/s)</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Velocity (m/s)</th>
                  @break
                  @case('tss') {{-- TSS Analysis --}}
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">TSS Inlet (mg/L)</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">TSS Outlet (mg/L)</th>
                  @break
                  @endswitch
                  @endif
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($data as $index => $row)
                <tr class="{{ $index % 2 == 0 ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800/50' }} hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                    {{ $index + 1 }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                    {{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                      {{ $row->location_name }}
                    </span>
                  </td>

                  @if(isset($reportType))
                  @switch($reportType)
                  @case('ph') {{-- pH Analysis --}}
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->ph_inlet }}</td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->ph_outlet_1 }}</td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->ph_outlet_2 }}</td>
                  @break
                  @case('debit') {{-- Debit Analysis --}}
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->debit }}</td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->velocity }}</td>
                  @break
                  @case('tss') {{-- TSS Analysis --}}
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->tss_inlet }}</td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $row->tss_outlet }}</td>
                  @break
                  @endswitch
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif

    </div>
  </main>
  <!-- ===== Main Content End ===== -->

  @endsection

  @push('scripts')
  <!-- Sweet Alert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const monthSelect = document.getElementById('month_value');
      const yearSelect = document.getElementById('year_value');
      const form = document.getElementById('printReportForm');
      const searchBtn = document.getElementById('searchBtn');

      const months = [{
          value: '01',
          text: 'Januari'
        },
        {
          value: '02',
          text: 'Februari'
        },
        {
          value: '03',
          text: 'Maret'
        },
        {
          value: '04',
          text: 'April'
        },
        {
          value: '05',
          text: 'Mei'
        },
        {
          value: '06',
          text: 'Juni'
        },
        {
          value: '07',
          text: 'Juli'
        },
        {
          value: '08',
          text: 'Agustus'
        },
        {
          value: '09',
          text: 'September'
        },
        {
          value: '10',
          text: 'Oktober'
        },
        {
          value: '11',
          text: 'November'
        },
        {
          value: '12',
          text: 'Desember'
        },
      ];

      function fillMonthOptions() {
        monthSelect.innerHTML = '<option value="">Pilih Bulan</option>';
        months.forEach(m => {
          const option = document.createElement('option');
          option.value = m.value;
          option.textContent = m.text;
          if ("{{ request('month_value') }}" === m.value) option.selected = true;
          monthSelect.appendChild(option);
        });
      }

      function fillYearOptions() {
        const currentYear = new Date().getFullYear();
        yearSelect.innerHTML = '<option value="">Pilih Tahun</option>';
        for (let y = currentYear; y >= currentYear - 10; y--) {
          const option = document.createElement('option');
          option.value = y.toString();
          option.textContent = y.toString();
          if ("{{ request('year_value') }}" === y.toString()) option.selected = true;
          yearSelect.appendChild(option);
        }
      }

      fillMonthOptions();
      fillYearOptions();
    });

    // Handle form submission dengan SweetAlert
    function handleFormSubmit(event) {
      event.preventDefault();

      const form = document.getElementById('printReportForm');
      const reportType = form.querySelector('select[name="report_type"]').value;
      const month = form.querySelector('select[name="month_value"]').value;
      const year = form.querySelector('select[name="year_value"]').value;

      if (!reportType || !month || !year) {
        Swal.fire({
          icon: 'error',
          title: 'Validasi Gagal!',
          text: 'Harap lengkapi semua field yang diperlukan',
          confirmButtonText: 'OK',
          confirmButtonColor: '#ef4444',
          timer: 3000,
          timerProgressBar: true
        });
        return false;
      }

      // Tampilkan loading
      Swal.fire({
        title: 'Generating Report...',
        html: 'Mohon tunggu sebentar, kami sedang mengambil data yang sudah disetujui',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
          Swal.showLoading();
        }
      });

      // Submit form
      setTimeout(() => {
        form.submit();
      }, 500);

      return false;
    }
  </script>
  @endpush

  @push('styles')
  <style>
    @media print {
      body * {
        visibility: hidden;
      }

      .print-section,
      .print-section * {
        visibility: visible;
      }

      .print-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }

      .no-print {
        display: none !important;
      }

      /* Reset backgrounds for print */
      .print-section * {
        background: white !important;
        color: black !important;
      }

      /* Keep borders */
      table,
      th,
      td {
        border-color: #e5e7eb !important;
      }
    }

    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
      height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    /* Smooth transitions */
    #noDataAlert {
      transition: all 0.3s ease-in-out;
    }
  </style>
  @endpush