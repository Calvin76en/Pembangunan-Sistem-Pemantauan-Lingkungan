@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Form Curah Hujan`}">
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
            <li>
              <a
                class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                href="lokasi-curah.html">
                Lokasi Pemantauan
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

    <!-- ====== Form Layouts Section Start -->
    <div class="max-w-4xl mx-auto p-6 sm:p-8 space-y-6">
      <form
        action="{{ isset($data_limbah) ? route('update.curah', $data_limbah->id) : route('store.curah') }}"
        method="POST">
        @csrf

        @if(isset($data_limbah))
        @method('PUT')
        @endif

        <!-- Informasi Lokasi Pemantauan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-md p-6">
            <h4 class="text-lg font-semibold text-brand-600 dark:text-brand-400 mb-4">Informasi Lokasi Pemantauan</h4>
            <p>
              @if (session('success'))
            <div class="mt-6 rounded-xl border-l-4 border-green-600 bg-green-100 px-6 py-4 shadow-lg dark:bg-green-950 dark:border-green-500 dark:text-green-100 animate-fade-in">
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="flex-1 text-sm font-medium text-green-800 dark:text-green-100">
                  {{ session('success') }}
                </div>
              </div>
            </div>
            @endif
            </p>
            <div class="space-y-6">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">ID Lokasi</label>
                  <input type="text" value="{{ $location_id }}" readonly
                    class="h-10 w-full rounded-lg border border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white/90 px-4 py-2.5 text-sm" />
                </div>
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Nama Lokasi</label>
                  <input type="text" value="{{ $location_name }}" readonly
                    class="h-10 w-full rounded-lg border border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white/90 px-4 py-2.5 text-sm" />
                </div>
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Tipe Pemantauan</label>
                  <input type="text" value="{{ $monitoring_type }}" readonly
                    class="h-10 w-full rounded-lg border border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white/90 px-4 py-2.5 text-sm" />
                </div>
              </div>
            </div>
          </div>

          <!-- Form Input Curah Hujan -->
          <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-md p-6">
            <h4 class="text-lg font-semibold text-brand-600 dark:text-brand-400 mb-4">Form Input Curah Hujan</h4>
            <div class="space-y-2">
              <div class="w-full px-2.5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                  Curah Hujan (MM)
                </label>
                <input
                  type="number"
                  name="CH"
                  placeholder="Masukkan jumlah curah hujan (dalam MM)"
                  value="{{ old('CH', $data_limbah->CH ?? '') }}"
                  class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                   />

                <!-- Jam Mulai -->
                <div class="w-full px-2.5">
                  <label class="text-sm text-gray-600 dark:text-gray-400">Jam Mulai</label>
                  <input
                    type="time"
                    name="jam_mulai"
                    value="{{ old('jam_mulai', $data_limbah->jam_mulai ?? '') }}"
                    class="mt-1 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                     />
                </div>

                <!-- Jam Selesai -->
                <div class="w-full px-2.5">
                  <label class="text-sm text-gray-600 dark:text-gray-400">Jam Selesai</label>
                  <input
                    type="time"
                    name="jam_selesai"
                    value="{{ old('jam_selesai', $data_limbah->jam_selesai ?? '') }}"
                    class="mt-1 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                     />
                </div>
              </div>
            </div>
          </div>

          <!-- Hidden Fields -->
          <input type="hidden" name="location_id" value="{{ $location_id }}">
          <input type="hidden" name="monitoring_id" value="{{ $monitoring_id }}">

          <!-- Submit Button -->
          <div class="pt-6">
            <button type="submit"
              class="w-full sm:w-auto px-6 py-3 bg-success-500 hover:bg-success-600 text-white font-medium rounded-xl shadow-md transition">
              {{ isset($data_limbah) ? 'Update Data' : 'Simpan Data' }}
            </button>
          </div>
      </form>
    </div>
  </div>

  <!-- ====== Form Layouts Section End -->
  </div>


</main>

@endsection