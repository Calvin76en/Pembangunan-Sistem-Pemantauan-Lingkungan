@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-7xl p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Oil Trap & Fuel Trap`}">
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

    <!-- Main Form Card -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
      <form id="oilfuelForm" action="{{ route('store.oilfuel') }}" method="POST" onsubmit="return handleFormSubmit(event)">
        @csrf
        <!-- Hidden Fields -->
        <input type="hidden" name="location_id" value="{{ $location_id }}">
        <input type="hidden" name="monitoring_id" value="{{ $monitoring_id }}">
        <input type="hidden" name="date" value="{{ $selectedDate }}">

        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div> -->
              <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Form Monitoring</h3>
                <p class="text-gray-600 dark:text-gray-400">Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Body -->
        <div class="px-8 py-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Informasi Lokasi Pemantauan -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
              <div class="flex items-center mb-6">
                <!-- <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div> -->
                <h4 class="text-lg font-semibold text-black dark:text-black">Informasi Lokasi</h4>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lokasi</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                      </svg>
                    </div>
                    <input type="text" value="{{ $location_name }}" readonly
                      class="pl-10 h-12 w-full rounded-xl border border-gray-300 bg-white/50 dark:bg-gray-800/50 dark:text-white/90 px-4 py-3 text-sm font-medium cursor-not-allowed" />
                  </div>
                </div>

                <div>
                  <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Pemantauan</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                      </svg>
                    </div>
                    <input type="text" value="{{ $monitoring_type }}" readonly
                      class="pl-10 h-12 w-full rounded-xl border border-gray-300 bg-white/50 dark:bg-gray-800/50 dark:text-white/90 px-4 py-3 text-sm font-medium cursor-not-allowed" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Input pH -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
              <div class="flex items-center mb-6">
                <!-- <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div> -->
                <h4 class="text-lg font-semibold text-black dark:text-black">Data Monitoring pH</h4>
              </div>

              <!-- pH Normal Range Info -->
              <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl">
                <div class="flex items-center">
                  <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="text-sm font-medium text-amber-700 dark:text-amber-300">
                    <span class="font-bold">Rentang Normal pH:</span> 6.0 - 9.0
                  </p>
                </div>
              </div>

              <div>
                <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                  Nilai pH <span class="text-red-500">*</span>
                </label>
                @if (isset($existingData))
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input type="number" step="0.01" name="ph" min="6" max="9"
                    value="{{ old('ph', $existingData->ph ?? '') }}"
                    class="pl-12 h-14 w-full rounded-xl border-2 border-green-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 shadow-sm focus:border-green-500 focus:ring-4 focus:ring-green-500/20 focus:outline-none transition-all duration-200"
                    required />
                </div>
                <p class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                  </svg>
                  Data pH sudah diisi dan dapat diubah jika diperlukan
                </p>
                @else
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input type="number" step="0.01" name="ph" placeholder="Contoh: 7.5" min="6" max="9"
                    class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-green-500 focus:ring-4 focus:ring-green-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400"
                    required />
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                  Masukkan nilai pH antara 6.0 hingga 9.0 dengan maksimal 2 desimal
                </p>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Form Footer -->
        <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Pastikan nilai pH berada dalam rentang 6.0 - 9.0
            </div>

            <div class="flex gap-3">
              <a href="{{ route('lokasi-oilfuel') }}?date={{ $selectedDate }}"
                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
              </a>

              <button type="submit"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/30 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ isset($existingData) ? 'Update Data' : 'Simpan Data' }}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>
<!-- ===== Main Content End ===== -->

@endsection

@push('scripts')
<!-- Sweet Alert 2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Handle form submission dengan SweetAlert
  function handleFormSubmit(event) {
    event.preventDefault();

    const form = document.getElementById('oilfuelForm');
    const phInput = form.querySelector('input[name="ph"]');
    const phValue = parseFloat(phInput.value);

    // Validasi pH
    if (isNaN(phValue) || phValue < 6 || phValue > 9) {
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        text: 'Nilai pH harus berada dalam rentang 6.0 - 9.0',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ef4444',
        timer: 3000,
        timerProgressBar: true
      });
      return false;
    }

    // Tampilkan loading
    Swal.fire({
      title: 'Menyimpan Data...',
      html: 'Mohon tunggu sebentar',
      allowOutsideClick: false,
      showConfirmButton: false,
      willOpen: () => {
        Swal.showLoading();
      }
    });

    // Submit form dengan delay untuk simulasi
    setTimeout(() => {
      // Tampilkan success popup
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil disimpan',
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: true,
        willClose: () => {
          // Submit form setelah popup ditutup
          form.submit();
        }
      });
    }, 1000);

    return false;
  }

  // Jika ada session success dari server
  @if(session('success'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('
      success ') }}',
      timer: 3000,
      showConfirmButton: false,
      timerProgressBar: true,
      position: 'top-end',
      toast: true,
      showClass: {
        popup: 'animate__animated animate__fadeInDown'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
      }
    });
  });
  @endif

  // Jika ada session error dari server
  @if(session('error'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: '{{ session('
      error ') }}',
      confirmButtonText: 'OK',
      confirmButtonColor: '#ef4444',
      position: 'center',
      showClass: {
        popup: 'animate__animated animate__shakeX'
      }
    });
  });
  @endif
</script>
@endpush

@push('styles')
<style>
  /* Animate.css integration for SweetAlert */
  @keyframes animate__fadeInDown {
    from {
      opacity: 0;
      transform: translate3d(0, -100%, 0);
    }

    to {
      opacity: 1;
      transform: translate3d(0, 0, 0);
    }
  }

  @keyframes animate__fadeOutUp {
    from {
      opacity: 1;
    }

    to {
      opacity: 0;
      transform: translate3d(0, -100%, 0);
    }
  }

  @keyframes animate__shakeX {

    from,
    to {
      transform: translate3d(0, 0, 0);
    }

    10%,
    30%,
    50%,
    70%,
    90% {
      transform: translate3d(-10px, 0, 0);
    }

    20%,
    40%,
    60%,
    80% {
      transform: translate3d(10px, 0, 0);
    }
  }

  .animate__animated {
    animation-duration: 0.5s;
    animation-fill-mode: both;
  }

  .animate__fadeInDown {
    animation-name: animate__fadeInDown;
  }

  .animate__fadeOutUp {
    animation-name: animate__fadeOutUp;
  }

  .animate__shakeX {
    animation-name: animate__shakeX;
  }

  /* Custom SweetAlert styling */
  .swal2-popup {
    border-radius: 1rem !important;
  }

  .swal2-timer-progress-bar {
    background: linear-gradient(to right, #10b981, #059669) !important;
  }
</style>
@endpush