@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-7xl p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Form Pengukuran Kebisingan`}">
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
            <li>
              <a href="{{ route('lokasi-kebisingan') }}" class="inline-flex items-center gap-1.5 hover:underline transition-colors">
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

    @php
    $isEdit = isset($data) && $data->isNotEmpty();
    $formAction = $isEdit ? route('update.kebisingan') : route('store.kebisingan');

    // Siapkan data existing untuk edit
    $existingSpl = [];
    if ($isEdit) {
        foreach ($data as $item) {
            // Extract nomor dari string "L1", "L2", dst.
            $index = intval(substr($item->second, 1));
            $existingSpl[$index] = $item->spl_db;
        }
    }
    $maxIndex = $isEdit && !empty($existingSpl) ? max(array_keys($existingSpl)) : 1;
    @endphp

    <!-- Main Form Card -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
      <form id="kebisinganForm" method="POST" action="{{ $formAction }}" onsubmit="return handleFormSubmit(event)">
        @csrf

        <!-- Hidden fields -->
        <input type="hidden" name="date" value="{{ $selectedDate }}">
        <input type="hidden" name="location_id" value="{{ $location_id }}">
        <input type="hidden" name="monitoring_id" value="{{ $monitoring_id }}">

        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                  <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                </svg>
              </div> -->
              <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Form Monitoring Kebisingan</h3>
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
                <!-- <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div> -->
                <h4 class="text-lg font-semibold text-black dark:text-black">Informasi Lokasi</h4>
              </div>
              
              <div class="space-y-4">
                <div>
                  <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lokasi</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v7h3.5c.85 0 1.64.42 2.12 1.13l2.72 4.04c.37.55.99.88 1.66.88.67 0 1.29-.33 1.66-.88l2.72-4.04c.48-.71 1.27-1.13 2.12-1.13H20V4H4zm0 9v7h7v-2.28l-1.34-1.99c-.95-1.42-2.55-2.23-4.16-2.23H4zm9 7h7v-6.5h-1.5c-1.61 0-3.21.81-4.16 2.23L13 17.72V20z"/>
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
                      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                      </svg>
                    </div>
                    <input type="text" value="{{ $monitoring_type }}" readonly
                      class="pl-10 h-12 w-full rounded-xl border border-gray-300 bg-white/50 dark:bg-gray-800/50 dark:text-white/90 px-4 py-3 text-sm font-medium cursor-not-allowed" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Input Data Kebisingan -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-emerald-200 dark:border-gray-600">
              <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 20H4v-4h4v4zm0-6H4v-4h4v4zm0-6H4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4z"/>
                  </svg>
                </div>
                <h4 class="text-lg font-semibold text-emerald-700 dark:text-emerald-300">Data Monitoring Kebisingan</h4>
              </div>
              
              <div class="space-y-5">
                <!-- Container untuk input dinamis -->
                <div>
                  <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Pengukuran SPL (dB) <span class="text-red-500">*</span>
                  </label>
                  
                  <div id="form-container" class="space-y-3 max-h-[400px] overflow-y-auto bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    @if($isEdit && !empty($existingSpl))
                    <!-- Tampilkan data existing saat edit -->
                    @for($i = 1; $i <= $maxIndex; $i++)
                    <div class="flex items-center gap-4">
                      <label class="w-20 font-semibold text-center text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-900 rounded-lg py-2" for="spl-{{ $i }}">L{{ $i }}</label>
                      <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                          <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                          </svg>
                        </div>
                        <input
                          id="spl-{{ $i }}"
                          type="number"
                          step="0.1"
                          min="0"
                          name="spl[{{ $i }}]"
                          value="{{ $existingSpl[$i] ?? '' }}"
                          class="pl-12 pr-14 h-12 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-green-500 focus:ring-4 focus:ring-green-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400"
                          placeholder="0.0"
                          required />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                          <span class="text-gray-500 text-sm font-medium">dB</span>
                        </div>
                      </div>
                    </div>
                    @endfor
                    @else
                    <!-- Form kosong untuk tambah baru -->
                    <div class="flex items-center gap-4">
                      <label class="w-20 font-semibold text-center text-gray-700 dark:text-gray-300 bg-green-100 dark:bg-green-900 rounded-lg py-2" for="spl-1">L1</label>
                      <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                          <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                          </svg>
                        </div>
                        <input
                          id="spl-1"
                          type="number"
                          step="0.1"
                          min="0"
                          name="spl[1]"
                          class="pl-12 pr-14 h-12 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-green-500 focus:ring-4 focus:ring-green-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400"
                          placeholder="0.0"
                          required />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                          <span class="text-gray-500 text-sm font-medium">dB</span>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                  
                  <!-- Tombol Tambah Data -->
                  <div class="mt-4 flex justify-center">
                    <button
                      type="button"
                      id="add-row-btn"
                      class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                      <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                      </svg>
                      Tambah Data
                    </button>
                  </div>
                </div>
              </div>

              @if($isEdit)
              <p class="mt-4 text-xs text-amber-600 dark:text-amber-400 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Data sudah ada dan dapat diubah jika diperlukan
              </p>
              @else
              <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                Masukkan minimal satu data pengukuran SPL. Maksimal 120 data pengukuran.
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
              <a href="{{ route('lokasi-kebisingan') }}?date={{ $selectedDate }}"
                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Kembali
              </a>
              
              <button type="submit"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/30 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
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
    
    const form = document.getElementById('kebisinganForm');
    const splInputs = form.querySelectorAll('input[type="number"]');
    let hasValue = false;
    
    // Check if at least one input has value
    splInputs.forEach(input => {
      if (input.value) {
        hasValue = true;
      }
    });
    
    if (!hasValue) {
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        text: 'Harap isi minimal satu data pengukuran SPL',
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

  // Dynamic form management
  document.addEventListener('DOMContentLoaded', function() {
    const maxRows = 120;
    const formContainer = document.getElementById('form-container');
    const addRowBtn = document.getElementById('add-row-btn');

    // Get current max index
    let currentMaxIndex = {{ $isEdit && !empty($existingSpl) ? $maxIndex : 1 }};

    addRowBtn.addEventListener('click', function() {
      const currentRows = formContainer.querySelectorAll('input[type="number"]').length;
      if (currentRows < maxRows) {
        const nextIndex = currentMaxIndex + 1;

        // Buat elemen baru baris input
        const newRow = document.createElement('div');
        newRow.className = 'flex items-center gap-4';
        newRow.innerHTML = `
          <label for="spl-${nextIndex}" class="w-20 font-semibold text-center text-gray-700 dark:text-gray-300 bg-green-100 dark:bg-green-900 rounded-lg py-2">L${nextIndex}</label>
          <div class="relative flex-1">
            
            <input
              id="spl-${nextIndex}"
              type="number"
              step="0.1"
              min="0"
              name="spl[${nextIndex}]"
              class="pl-12 pr-14 h-12 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-green-500 focus:ring-4 focus:ring-green-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400"
              placeholder="0.0"
              required />
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
              <span class="text-gray-500 text-sm font-medium">dB</span>
            </div>
          </div>
        `;
        formContainer.appendChild(newRow);

        // Update current max index
        currentMaxIndex = nextIndex;

        // Scroll ke bawah agar input baru terlihat
        formContainer.scrollTop = formContainer.scrollHeight;

        // Add animation
        newRow.style.opacity = '0';
        newRow.style.transform = 'translateY(-10px)';
        setTimeout(() => {
          newRow.style.transition = 'all 0.3s ease';
          newRow.style.opacity = '1';
          newRow.style.transform = 'translateY(0)';
        }, 10);

        // Disable tombol jika sudah mencapai maxRows
        if (currentRows + 1 >= maxRows) {
          addRowBtn.disabled = true;
          addRowBtn.classList.add('opacity-50', 'cursor-not-allowed');
          addRowBtn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19 13H5v-2h14v2z"/>
            </svg>
            Maksimal 120 Data
          `;
        }
      }
    });

    // Jika ada session success dari server
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
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
    @endif

    // Jika ada session error dari server
    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ef4444',
        position: 'center',
        showClass: {
          popup: 'animate__animated animate__shakeX'
        }
      });
    @endif
  });
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
    from, to {
      transform: translate3d(0, 0, 0);
    }
    10%, 30%, 50%, 70%, 90% {
      transform: translate3d(-10px, 0, 0);
    }
    20%, 40%, 60%, 80% {
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

  /* Custom scrollbar for form container */
  #form-container::-webkit-scrollbar {
    width: 8px;
  }

  #form-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  #form-container::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 10px;
  }

  #form-container::-webkit-scrollbar-thumb:hover {
    background: #059669;
  }
</style>
@endpush