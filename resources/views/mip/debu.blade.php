@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-7xl p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Form Debu`}">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
        <nav>
          <ol class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
            <li>
              <a href="{{ route('mip-lokasi-debu') }}" class="inline-flex items-center gap-1.5 hover:underline transition-colors">
                Home
                <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
            </li>
            <li>
              <a href="{{ route('mip-lokasi-debu', ['date' => $selectedDate]) }}" class="inline-flex items-center gap-1.5 hover:underline transition-colors">
                Lokasi Pemantauan
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
      <form id="debuForm" action="{{ (isset($data_debu) && $data_debu) ? route('update.debu', $data_debu->id) : route('store.debu') }}" method="POST" onsubmit="return handleFormSubmit(event)">
        @csrf
        @if(isset($data_debu) && $data_debu)
        @method('PUT')
        @endif

        <!-- Hidden Fields -->
        <input type="hidden" name="selectedDate" value="{{ $selectedDate }}">
        <input type="hidden" name="location_id" value="{{ $location_id }}">
        <input type="hidden" name="monitoring_id" value="{{ $monitoring_id }}">

        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13h1M4 13H3m12.364-6.364l-.707-.707M5.343 5.343l-.707-.707m12.728 0l-.707.707M5.343 16.657l-.707.707M12 3a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div> -->
              <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Form Monitoring Debu</h3>
                <p class="text-gray-600 dark:text-gray-400">Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</p>
              </div>
            </div>
          </div>
        </div>


        <!-- Form Body -->
        <div class="px-8 py-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Informasi Lokasi Pemantauan -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-orange-200 dark:border-gray-600">
              <div class="flex items-center mb-6">
                <!-- <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div> -->
                <h4 class="text-lg font-semibold text-orange-700 dark:text-orange-300">Informasi Lokasi</h4>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                      </svg>
                    </div>
                    <input type="text" value="{{ $monitoring_type }}" readonly
                      class="pl-10 h-12 w-full rounded-xl border border-gray-300 bg-white/50 dark:bg-gray-800/50 dark:text-white/90 px-4 py-3 text-sm font-medium cursor-not-allowed" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Input Data Debu -->
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-amber-200 dark:border-gray-600">
              <div class="flex items-center mb-6">
                <!-- <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                  </svg>
                </div> -->
                <h4 class="text-lg font-semibold text-amber-700 dark:text-amber-300">Data Monitoring Debu</h4>
              </div>

              <div class="space-y-5">
                <!-- Waktu Pemantauan -->
                <div>
                  <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Waktu Pemantauan <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <select name="waktu"
                      class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 shadow-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400 @error('waktu') border-red-500 @enderror">
                      <option value="">Pilih Waktu Pemantauan</option>
                      <option value="Pagi" {{ old('waktu', (isset($data_debu) && $data_debu) ? $data_debu->waktu : '') == 'Pagi' ? 'selected' : '' }}>
                        Pagi (06:00 - 11:00)
                      </option>
                      <option value="Siang" {{ old('waktu', (isset($data_debu) && $data_debu) ? $data_debu->waktu : '') == 'Siang' ? 'selected' : '' }}>
                        Siang (11:00 - 15:00)
                      </option>
                      <option value="Sore" {{ old('waktu', (isset($data_debu) && $data_debu) ? $data_debu->waktu : '') == 'Sore' ? 'selected' : '' }}>
                        Sore (15:00 - 18:00)
                      </option>
                    </select>
                  </div>
                  @error('waktu')
                  <p class="mt-2 text-xs text-red-600 dark:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                  </p>
                  @enderror
                </div>

                <!-- Status Debu -->
                <div>
                  <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status Debu <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <select name="status_debu"
                      class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 shadow-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400 @error('status_debu') border-red-500 @enderror">
                      <option value="">Pilih Status Debu</option>
                      <option value="ST" {{ old('status_debu', (isset($data_debu) && $data_debu) ? $data_debu->status_debu : '') == 'ST' ? 'selected' : '' }}>
                        Sangat Tebal (ST)
                      </option>
                      <option value="T" {{ old('status_debu', (isset($data_debu) && $data_debu) ? $data_debu->status_debu : '') == 'T' ? 'selected' : '' }}>
                        Tebal (T)
                      </option>
                      <option value="M" {{ old('status_debu', (isset($data_debu) && $data_debu) ? $data_debu->status_debu : '') == 'M' ? 'selected' : '' }}>
                        Minim (M)
                      </option>
                      <option value="SM" {{ old('status_debu', (isset($data_debu) && $data_debu) ? $data_debu->status_debu : '') == 'SM' ? 'selected' : '' }}>
                        Sangat Minim (SM)
                      </option>
                    </select>
                  </div>
                  @error('status_debu')
                  <p class="mt-2 text-xs text-red-600 dark:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                  </p>
                  @enderror
                </div>
              </div>

              @if(isset($data_debu) && $data_debu)
              <p class="mt-4 text-xs text-amber-600 dark:text-amber-400 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Data sudah ada dan dapat diubah jika diperlukan
              </p>
              @else
              <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                Pilih waktu pemantauan dan status debu yang sesuai
              </p>
              @endif
            </div>
          </div>
        </div>

        <!-- Form Footer -->
        <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">

            </div>

            <div class="flex gap-3">
              <a href="{{ route('mip-lokasi-debu', ['date' => $selectedDate]) }}"
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
                {{ (isset($data_debu) && $data_debu) ? 'Update Data' : 'Simpan Data' }}
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

    const form = document.getElementById('debuForm');
    const waktuInput = form.querySelector('select[name="waktu"]');
    const statusDebuInput = form.querySelector('select[name="status_debu"]');

    const waktuValue = waktuInput.value;
    const statusDebuValue = statusDebuInput.value;

    // Validasi minimal satu field harus diisi
    if (!waktuValue || !statusDebuValue) {
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        text: 'Harap pilih waktu pemantauan dan status debu',
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
    background: linear-gradient(to right, #f97316, #f59e0b) !important;
  }
</style>
@endpush