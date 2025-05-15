@extends('layout.mip.dash')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Air Limbah Tambang`}">
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

    <!-- ====== Form Layouts Section Start -->
    <div class="space-y-6">
      <!-- Judul Besar seperti di Gambar -->
      <div class="max-w-5xl mx-auto space-y-6 p-6 sm:p-8">
        <!-- Judul Besar -->
        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-xl shadow-sm text-center">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Pemantauan Air Limbah Tambang</h2>
          <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Lokasi: {{ $location_name }} | ID Lokasi: {{ $location_id }}</p>
          <p>
            @if (session('success'))
            <div class="mt-6 rounded-xl border-l-4 border-green-600 bg-green-100 px-6 py-4 shadow-lg dark:bg-green-950 dark:border-green-500 dark:text-green-100 animate-fade-in">
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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

        <!-- Card Form -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-md">
          <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Form Input Data Pemantauan Air Limbah</h3>
          </div>
          <form action="{{ isset($data_limbah) ? route('update.limbah', $data_limbah->id) : route('store.limbah') }}" method="POST">
            @csrf
            @if(isset($data_limbah))
            @method('PUT')
            <input type="hidden" name="id" value="{{ $data_limbah->id }}">
            @endif
            <!-- Section pH -->
            <input type="hidden" name="location_id" value="{{ $location_id }}" />
            <input type="hidden" name="monitoring_id" value="{{ $monitoring_id ?? 1 }}" />

            <div>
              <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-4">pH</h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">pH Inlet</label>
                  <input type="number" step="0.01" name="ph_inlet" placeholder="pH Inlet"
                    value="{{ old('ph_inlet', $data_limbah->ph_inlet ?? '') }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                </div>
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">pH Outlet 1</label>
                  <input type="number" step="0.01" name="ph_outlet_1" placeholder="pH Outlet 1"
                    value="{{ old('ph_outlet_1', $data_limbah->ph_outlet_1 ?? '') }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                </div>
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">pH Outlet 2</label>
                  <input type="number" step="0.01" name="ph_outlet_2" placeholder="pH Outlet 2"
                    value="{{ old('ph_outlet_2', $data_limbah->ph_outlet_2 ?? '') }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                </div>
              </div>
            </div><br>

            <!-- Section Treatment -->
            <div>
              <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-4">Treatment</h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="flex flex-col sm:flex-row gap-6">
                  <div class="flex-1">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Kapur</label>
                    <input type="number" step="0.01" name="treatment_kapur" placeholder="Jumlah Kapur"
                      value="{{ old('treatment_kapur', $data_limbah->treatment_kapur ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                  <div class="flex-1">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">PAC</label>
                    <input type="number" step="0.01" name="treatment_pac" placeholder="Jumlah PAC"
                      value="{{ old('treatment_pac', $data_limbah->treatment_pac ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                  <div class="flex-1">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">TAWAS</label>
                    <input type="number" step="0.01" name="treatment_tawas" placeholder="Jumlah TAWAS"
                      value="{{ old('treatment_tawas', $data_limbah->treatment_tawas ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                </div>
              </div><br>

              <!-- Section TSS -->
              <div>
                <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-4">TSS</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">TSS Inlet</label>
                    <input type="number" step="0.01" name="tss_inlet" placeholder="TSS Inlet"
                      value="{{ old('tss_inlet', $data_limbah->tss_inlet ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                  <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">TSS Outlet</label>
                    <input type="number" step="0.01" name="tss_outlet" placeholder="TSS Outlet"
                      value="{{ old('tss_outlet', $data_limbah->tss_outlet ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                </div>
              </div><br>

              <!-- Section Fe & Mn -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-2">Fe</h4>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Fe Outlet</label>
                  <input type="number" step="0.01" name="fe_outlet" placeholder="Fe Outlet"
                    value="{{ old('fe_outlet', $data_limbah->fe_outlet ?? '') }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                </div>
                <div>
                  <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-2">Mn</h4>
                  <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Mn Outlet</label>
                  <input type="number" step="0.01" name="mn_outlet" placeholder="Mn Outlet"
                    value="{{ old('mn_outlet', $data_limbah->mn_outlet ?? '') }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                </div>
              </div><br>

              <!-- Section Debit -->
              <div>
                <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-4">Debit</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Diameter (cm)</label>
                    <input type="number" step="0.01" name="debit" placeholder="Diameter"
                      value="{{ old('debit', $data_limbah->debit ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                  <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white/80">Kecepatan Aliran (m/s)</label>
                    <input type="number" step="0.01" name="velocity" placeholder="Kecepatan Aliran"
                      value="{{ old('velocity', $data_limbah->velocity ?? '') }}"
                      class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 shadow-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 focus:outline-none" />
                  </div>
                </div>
              </div><br>

              <!-- Section Keterangan -->
              <div>
                <h4 class="text-base font-semibold text-brand-600 dark:text-brand-400 mb-4">Keterangan</h4>
                <input
                  type="text"
                  name="keterangan"
                  placeholder="Jika outlet (-1), otomatis tambahkan 'ne' di akhir"
                  value="{{ old('keterangan', $data_limbah->keterangan ?? '') }}"
                  class="h-11 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm 
                  text-gray-800 dark:text-white/90 shadow-sm focus:border-brand-500 focus:ring-2 
                  focus:ring-brand-500/30 focus:outline-none" />
              </div><br><br>

              <!-- Submit Button -->
              <div class="pt-4">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-success-500 hover:bg-success-600 text-white font-medium rounded-xl shadow-md transition">
                  {{ isset($data_limbah) ? 'Update' : 'Simpan' }}
                </button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection
