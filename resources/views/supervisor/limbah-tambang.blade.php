@extends('layout.mip.dash')

@section('content')
<main>
  <div class="mx-auto max-w-5xl p-6">
    <!-- Breadcrumb -->
    <div x-data="{ pageName: `Air Limbah Tambang`}">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
        <nav>
          <ol class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
            <li>
              <a href="index.html" class="inline-flex items-center gap-1.5 hover:underline">
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

    <!-- Header Card -->
    <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 mb-8 shadow-sm text-center">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Pemantauan Air Limbah Tambang</h2>
      <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Lokasi: {{ $location_name }} | ID Lokasi: {{ $location_id }}</p>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tanggal : {{ $selectedDate ?? '-' }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 p-6 max-w-xl mx-auto">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 text-left">Form Input Data Pemantauan Air Limbah</h3>

    <form action="{{ isset($data_limbah) ? route('update.limbah', $data_limbah->id) : route('store.limbah') }}" method="POST" class="space-y-6">
      @csrf
      @if(isset($data_limbah))
        @method('PUT')
        <input type="hidden" name="id" value="{{ $data_limbah->id }}">
      @endif

      <input type="hidden" name="location_id" value="{{ $location_id }}" />
      <input type="hidden" name="monitoring_id" value="{{ $monitoring_id ?? 1 }}" />
      <input type="hidden" name="selectedDate" value="{{ $selectedDate ?? '' }}" />

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">

        <!-- Left Column -->
        <div>
          <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">pH</h4>
          <div class="space-y-3 max-w-[280px]">
            <div>
              <label for="ph_inlet" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">pH inlet</label>
              <input id="ph_inlet" type="number" step="0.01" name="ph_inlet" placeholder="pH Inlet"
                value="{{ old('ph_inlet', $data_limbah->ph_inlet ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>

            <div>
              <label for="ph_outlet_1" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">pH Outlet 1</label>
              <input id="ph_outlet_1" type="number" step="0.01" name="ph_outlet_1" placeholder="pH Outlet 1"
                value="{{ old('ph_outlet_1', $data_limbah->ph_outlet_1 ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>

            <div>
              <label for="ph_outlet_2" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">pH Outlet 2</label>
              <input id="ph_outlet_2" type="number" step="0.01" name="ph_outlet_2" placeholder="pH Outlet 2"
                value="{{ old('ph_outlet_2', $data_limbah->ph_outlet_2 ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>
          </div>

          <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mt-8 mb-4">TSS</h4>
          <div class="space-y-3 max-w-[280px]">
            <div>
              <label for="tss_inlet" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">TSS Inlet</label>
              <input id="tss_inlet" type="number" step="0.01" name="tss_inlet" placeholder="TSS Inlet"
                value="{{ old('tss_inlet', $data_limbah->tss_inlet ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>

            <div>
              <label for="tss_outlet" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">TSS Outlet</label>
              <input id="tss_outlet" type="number" step="0.01" name="tss_outlet" placeholder="TSS Outlet"
                value="{{ old('tss_outlet', $data_limbah->tss_outlet ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>
          </div>

          <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mt-8 mb-4">Fe</h4>
          <div class="max-w-[280px]">
            <label for="fe_outlet" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">Fe Outlet</label>
            <input id="fe_outlet" type="number" step="0.01" name="fe_outlet" placeholder="Fe Outlet"
              value="{{ old('fe_outlet', $data_limbah->fe_outlet ?? '') }}"
              class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
              text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
              focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
          </div>
        </div>

        <!-- Right Column -->
        <div>
          <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Treatment</h4>
          <div class="space-y-3 max-w-[280px]">
            <div>
              <label for="treatment_kapur" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">Kapur</label>
              <input id="treatment_kapur" type="number" step="0.01" name="treatment_kapur" placeholder="Jumlah Kapur"
                value="{{ old('treatment_kapur', $data_limbah->treatment_kapur ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>

            <div>
              <label for="treatment_pac" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">PAC</label>
              <input id="treatment_pac" type="number" step="0.01" name="treatment_pac" placeholder="Jumlah PAC"
                value="{{ old('treatment_pac', $data_limbah->treatment_pac ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>

            <div>
              <label for="treatment_tawas" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">Tawas</label>
              <input id="treatment_tawas" type="number" step="0.01" name="treatment_tawas" placeholder="Jumlah Tawas"
                value="{{ old('treatment_tawas', $data_limbah->treatment_tawas ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>
          </div>

          <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mt-8 mb-4">Debit</h4>
          <div class="space-y-3 max-w-[280px]">
            <div>
              <label for="debit" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">Diameter (cm)</label>
              <input id="debit" type="number" step="0.01" name="debit" placeholder="Diameter"
                value="{{ old('debit', $data_limbah->debit ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>

            <div>
              <label for="velocity" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">Kecepatan Aliran (m/s)</label>
              <input id="velocity" type="number" step="0.01" name="velocity" placeholder="Kecepatan Aliran"
                value="{{ old('velocity', $data_limbah->velocity ?? '') }}"
                class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm
                text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 shadow-sm
                focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
            </div>
          </div>

          <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mt-8 mb-4">Mn</h4>
          <div class="max-w-[280px]">
            <label for="mn_outlet" class="block mb-1 text-sm font-semibold text-gray-600 dark:text-gray-400">Mn Outlet</label>
            <input id="mn_outlet" type="number" step="0.01" name="mn_outlet" placeholder="Mn Outlet"
              value="{{ old('mn_outlet', $data_limbah->mn_outlet ?? '') }}"
              class="h-10 w-full max-w-[280px] rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm text-gray-500 placeholder-gray-300 dark:placeholder-gray-600 shadow-sm
              focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
          </div>
        </div>
      </div>

      <!-- Keterangan -->
      <div class="mt-6 max-w-[280px]">
        <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-3">Keterangan</h4>
        <input
          type="text"
          name="keterangan"
          placeholder="Jika outlet (-1), otomatis tambahkan 'ne' di akhir"
          value="{{ old('keterangan', $data_limbah->keterangan ?? '') }}"
          class="h-10 w-full rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm text-gray-500 placeholder-gray-300 dark:placeholder-gray-600 shadow-sm
          focus:border-green-600 focus:ring-1 focus:ring-green-600 focus:outline-none" />
      </div>

      <!-- Submit Button -->
      <div class="pt-6 max-w-[280px]">
        <button type="submit" class="px-6 py-3 bg-success-500 hover:bg-success-600 text-white font-semibold rounded-md shadow-md transition w-full">
          {{ isset($data_limbah) ? 'Update' : 'Simpan Data' }}
        </button>
      </div>
    </form>
  </div>

  </div>
</main>
@endsection
