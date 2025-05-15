@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Form Debu`}">
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
                href="lokasi-debu.html">
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

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
      <!-- Card Informasi Lokasi Pemantauan Debu -->
      <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
              Informasi Lokasi Pemantauan Debu
            </h3>
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
          </div>
          <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
            <form>
              <div class="-mx-2.5 flex flex-wrap gap-y-5">
                <div class="w-full px-2.5 xl:w-1/2">
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">
                    ID Lokasi
                  </label>
                  <input
                    type="text"
                    value="{{ $location_id }}"
                    readonly
                    class="h-11 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800 dark:text-white/90" />
                </div>

                <div class="w-full px-2.5 xl:w-1/2">
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">
                    Nama Lokasi
                  </label>
                  <input
                    type="text"
                    value="{{ $location_name }}"
                    readonly
                    class="h-11 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800 dark:text-white/90" />
                </div>

                <div class="w-full px-2.5">
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">
                    Tipe Pemantauan
                  </label>
                  <input
                    type="text"
                    value="{{ $monitoring_type }}"
                    readonly
                    class="h-11 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800 dark:text-white/90" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Card Form Input Pemantauan Debu -->
      <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
              Form Input Pemantauan Debu
            </h3>
          </div>
          <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
<<<<<<< HEAD
            <form action="{{ isset($data_debu) ? route('update.debu', $data_debu->id) : route('store.debu') }}" method="POST">
              @csrf
              @if(isset($data_debu))
              @method('PUT')
              @endif

=======
            <form action="{{ route('store.debu') }}" method="POST">
              @csrf
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
              <div class="-mx-2.5 flex flex-wrap gap-y-5">
                <!-- Pilihan Waktu -->
                <div class="w-full px-2.5">
                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Waktu
                  </label>
                  <select
                    name="waktu"
<<<<<<< HEAD
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
=======
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                    required>
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
                    <option value="" disabled {{ old('waktu', optional($data_debu)->waktu) == null ? 'selected' : '' }}>Pilih Waktu Pemantauan</option>
                    <option value="Pagi" {{ old('waktu', optional($data_debu)->waktu) == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                    <option value="Siang" {{ old('waktu', optional($data_debu)->waktu) == 'Siang' ? 'selected' : '' }}>Siang</option>
                    <option value="Sore" {{ old('waktu', optional($data_debu)->waktu) == 'Sore' ? 'selected' : '' }}>Sore</option>
                  </select>
                </div>

                <!-- Pilihan Status Debu -->
                <div class="w-full px-2.5">
                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Status Debu
                  </label>
                  <select
                    name="status_debu"
<<<<<<< HEAD
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
=======
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                    required>
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
                    <option value="" disabled {{ old('status_debu', optional($data_debu)->status_debu) == null ? 'selected' : '' }}>Pilih Status Debu</option>
                    <option value="ST" {{ old('status_debu', optional($data_debu)->status_debu) == 'ST' ? 'selected' : '' }}>Sangat Tebal</option>
                    <option value="T" {{ old('status_debu', optional($data_debu)->status_debu) == 'T' ? 'selected' : '' }}>Tebal</option>
                    <option value="M" {{ old('status_debu', optional($data_debu)->status_debu) == 'M' ? 'selected' : '' }}>Minim</option>
                    <option value="SM" {{ old('status_debu', optional($data_debu)->status_debu) == 'SM' ? 'selected' : '' }}>Sangat Minim</option>
                  </select>
                </div>
              </div>

              <!-- Hidden Fields -->
              <input type="hidden" name="location_id" value="{{ $location_id }}">
              <input type="hidden" name="monitoring_id" value="{{ $monitoring_id }}">


              <div class="w-full px-2.5">
                <button
                  type="submit"
                  class="flex items-center mt-6 justify-center w-full gap-2 p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600">
                  Simpan Data
                  <svg
                    class="fill-current"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z" />
                  </svg>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- ====== Form Layouts Section End -->
  </div>


</main>


@endsection