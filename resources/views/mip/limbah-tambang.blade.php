@extends('layout.mip.dash')

@section('content')

<!-- ===== Main Content Start ===== -->
<main>
  <div class="mx-auto max-w-7xl p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Air Limbah Tambang`}">
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
      <form id="limbahForm" action="{{ isset($data_limbah) ? route('update.limbah', $data_limbah->id) : route('store.limbah') }}" method="POST" onsubmit="return handleFormSubmit(event)">
        @csrf
        @if(isset($data_limbah))
          @method('PUT')
          <input type="hidden" name="id" value="{{ $data_limbah->id }}">
        @endif

        <!-- Hidden Fields -->
        <input type="hidden" name="location_id" value="{{ $location_id }}" />
        <input type="hidden" name="monitoring_id" value="{{ $monitoring_id ?? 22000001 }}" />
        <input type="hidden" name="selectedDate" value="{{ $selectedDate ?? '' }}" />

        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M21.97 13.22c0-.89-.15-1.75-.43-2.53l-1.34 1.34c.05.31.08.63.08.97 0 2.25-1.22 4.21-3.02 5.19v3.28c2.89-.98 5.02-3.73 5.02-6.93 0-.36-.03-.71-.08-1.05l-.23-.27zM16.57 9.65c-.15-.39-.33-.77-.55-1.12l-.62.89c.16.27.29.57.38.88l.79-.65zM19.94 7.98l1.42-1.42-1.42-1.42-16.5 16.5 1.42 1.42L8.3 19.62C5.57 18.92 3.58 16.89 2.88 14.22c-.19-.71-.29-1.46-.29-2.24s.1-1.53.29-2.24c.47-1.78 1.37-3.33 2.57-4.5L3.5 3.28C1.91 5.04.91 7.3.91 9.78c0 2.02.61 3.88 1.61 5.44l-.02.03A9.969 9.969 0 0010 20a9.94 9.94 0 006.72-2.61l.93.93 1.42-1.42-.93-.93-.02-.02c.65-.62 1.18-1.37 1.53-2.21l-.79-.65c-.26.45-.58.87-.95 1.24l-7.6-7.6c.58-.26 1.21-.4 1.89-.4 1.34 0 2.57.51 3.5 1.34l1.06-1.06c-1.21-1.11-2.82-1.79-4.56-1.79-1.27 0-2.46.36-3.47.97l-1.3-1.3C8.12 4.22 9.03 4 10 4c3.64 0 6.67 2.62 7.32 6.08l1.72-1.72-.01-.01c-.87-2.44-2.82-4.29-5.25-4.89V2h-2v1.58C8.9 4.24 6.58 6.26 5.56 8.9l1.53 1.53c.43-1.43 1.47-2.58 2.82-3.14l.09.71zm-6.91 6.91l4.52 4.52c-.21.08-.42.15-.65.19v1.5c.52-.09 1.02-.23 1.48-.43l1.81 1.81A5.94 5.94 0 0114 18.08V20c1.1 0 2.16-.24 3.11-.68l1.42 1.42C17.24 21.54 15.68 22 14 22c-3.31 0-6.13-2.11-7.19-5.06l-1.45 1.45C6.83 20.47 9.22 22 12 22c1.12 0 2.19-.19 3.17-.52l1.33 1.33A11.93 11.93 0 0112 24C5.37 24 0 18.63 0 12c0-2.34.67-4.53 1.84-6.39L.42.17 1.83-1.25l22 22-1.41 1.42-8.39-8.39zm4.43 4.43L14 16.08v-2.65l2.48 2.48z"/>
                </svg>
              </div> -->
              <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Form Monitoring Air Limbah</h3>
                <p class="text-gray-600 dark:text-gray-400">Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') ?? '-' }} | Lokasi: {{ $location_name }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Body -->
        <div class="px-8 py-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Left Column -->
            <div class="space-y-6">
              <!-- pH Section -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-center mb-6">
                  <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
                    </svg>
                  </div> -->
                  <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Pengukuran pH</h4>
                </div>
                
                <div class="space-y-5">
                  <!-- pH Inlet -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      pH Inlet <span class="text-gray-500">(6.0 - 9.0)</span>
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2l-5.5 9h11z"/>
                          <circle cx="17.5" cy="17.5" r="4.5"/>
                          <path d="M3 13.5h8v8H3z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="ph_inlet" placeholder="0.00"
                        value="{{ old('ph_inlet', $data_limbah->ph_inlet ?? '') }}"
                        onblur="validateSinglePH(this)"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">pH</span>
                      </div>
                    </div>
                  </div>

                  <!-- pH Outlet 1 -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      pH Outlet 1 <span class="text-gray-500">(6.0 - 9.0)</span>
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2l-5.5 9h11z"/>
                          <circle cx="17.5" cy="17.5" r="4.5"/>
                          <path d="M3 13.5h8v8H3z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="ph_outlet_1" placeholder="0.00"
                        value="{{ old('ph_outlet_1', $data_limbah->ph_outlet_1 ?? '') }}"
                        onblur="validateSinglePH(this)"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">pH</span>
                      </div>
                    </div>
                  </div>

                  <!-- pH Outlet 2 -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      pH Outlet 2 <span class="text-gray-500">(6.0 - 9.0)</span>
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2l-5.5 9h11z"/>
                          <circle cx="17.5" cy="17.5" r="4.5"/>
                          <path d="M3 13.5h8v8H3z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="ph_outlet_2" placeholder="0.00"
                        value="{{ old('ph_outlet_2', $data_limbah->ph_outlet_2 ?? '') }}"
                        onblur="validateSinglePH(this)"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">pH</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- TSS Section -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-center mb-6">
                  <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9c.83 0 1.5-.67 1.5-1.5S7.83 8 7 8s-1.5.67-1.5 1.5S6.17 11 7 11zm3.5-1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5S12.83 8 12 8s-1.5.67-1.5 1.5zm5 0c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5S17.83 8 17 8s-1.5.67-1.5 1.5z"/>
                    </svg>
                  </div> -->
                  <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Suspended Solids (TSS)</h4>
                </div>
                
                <div class="space-y-5">
                  <!-- TSS Inlet -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      TSS Inlet
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="tss_inlet" placeholder="0.00"
                        value="{{ old('tss_inlet', $data_limbah->tss_inlet ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">mg/L</span>
                      </div>
                    </div>
                  </div>

                  <!-- TSS Outlet -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      TSS Outlet
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="tss_outlet" placeholder="0.00"
                        value="{{ old('tss_outlet', $data_limbah->tss_outlet ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">mg/L</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Fe Section -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-center mb-6">
                  <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M22 9V7h-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-2h2v-2h-2v-2h2v-2h-2V9h2zm-4 10H4V5h14v14zM6 13h5v4H6zm6-6h4v3h-4zM6 7h5v5H6zm6 4h4v6h-4z"/>
                    </svg>
                  </div> -->
                  <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Besi (Fe)</h4>
                </div>
                
                <div>
                  <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Fe Outlet
                  </label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      </svg>
                    </div>
                    <input type="number" step="0.01" name="fe_outlet" placeholder="0.00"
                      value="{{ old('fe_outlet', $data_limbah->fe_outlet ?? '') }}"
                      class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm font-medium">mg/L</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
              <!-- Treatment Section -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-center mb-6">
                  <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M7 19h10V4.828l-2-2-2 2-2-2-2 2-2-2v14.172l2 2zm5-16c1.103 0 2 .897 2 2v1h-4V5c0-1.103.897-2 2-2zM11 7h2v2h-2V7zm0 3h2v2h-2v-2zm-2 2H7v-2h2v2zm0-3H7V7h2v2zm6 0h-2V7h2v2zm0 3h-2v-2h2v2zm0 3H9v-2h6v2zm0 3H9v-2h6v2z"/>
                    </svg>
                  </div> -->
                  <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Treatment Kimia</h4>
                </div>
                
                <div class="space-y-5">
                  <!-- Kapur -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      Kapur
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="treatment_kapur" placeholder="0.00"
                        value="{{ old('treatment_kapur', $data_limbah->treatment_kapur ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">kg</span>
                      </div>
                    </div>
                  </div>

                  <!-- PAC -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      PAC (Poly Aluminium Chloride)
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="treatment_pac" placeholder="0.00"
                        value="{{ old('treatment_pac', $data_limbah->treatment_pac ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">kg</span>
                      </div>
                    </div>
                  </div>

                  <!-- Tawas -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      Tawas (Aluminium Sulfat)
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="treatment_tawas" placeholder="0.00"
                        value="{{ old('treatment_tawas', $data_limbah->treatment_tawas ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">kg</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Debit Section -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-center mb-6">
                  <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56c-.21.58-.66.97-1.18 1.01l-.45.02c-.18.01-.37 0-.56-.01l-.92-.05c-.42-.02-.82-.13-1.19-.3a2.69 2.69 0 0 0-2.48.03 2.74 2.74 0 0 1-1.21.32c-.31.01-.63-.02-.93-.07l-.45-.07c-.52-.07-.97-.45-1.18-1.03a1.33 1.33 0 0 1 .28-1.35c.36-.41.91-.55 1.4-.36.24.09.46.22.66.38.53.42 1.22.55 1.86.32.64-.23 1.37-.12 1.9.32.2.16.42.29.66.38.49.19 1.04.05 1.4-.36.5-.55.59-1.38.19-1.95z"/>
                    </svg>
                  </div> -->
                  <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Pengukuran Debit</h4>
                </div>
                
                <div class="space-y-5">
                  <!-- Diameter Pipa -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      Diameter Pipa
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="debit" placeholder="0.00"
                        value="{{ old('debit', $data_limbah->debit ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">cm</span>
                      </div>
                    </div>
                  </div>

                  <!-- Kecepatan Aliran -->
                  <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                      Kecepatan Aliran
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <input type="number" step="0.01" name="velocity" placeholder="0.00"
                        value="{{ old('velocity', $data_limbah->velocity ?? '') }}"
                        class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                      <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">m/s</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Mn Section -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-center mb-6">
                  <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M22 9V7h-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-2h2v-2h-2v-2h2v-2h-2V9h2zm-4 10H4V5h14v14zM6 13h5v4H6zm6-6h4v3h-4zM6 7h5v5H6zm6 4h4v6h-4z"/>
                    </svg>
                  </div> -->
                  <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Mangan (Mn)</h4>
                </div>
                
                <div>
                  <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Mn Outlet
                  </label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      </svg>
                    </div>
                    <input type="number" step="0.01" name="mn_outlet" placeholder="0.00"
                      value="{{ old('mn_outlet', $data_limbah->mn_outlet ?? '') }}"
                      class="pl-12 pr-14 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm font-medium">mg/L</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Keterangan Section -->
          <div class="mt-8 bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-teal-200 dark:border-gray-600">
            <div class="flex items-center mb-4">
              <!-- <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
              </div> -->
              <h4 class="text-lg font-semibold text-teal-700 dark:text-teal-300">Catatan & Keterangan</h4>
            </div>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                </svg>
              </div>
              <input type="text" name="keterangan" placeholder="Tambahkan catatan atau keterangan..."
                value="{{ old('keterangan', $data_limbah->keterangan ?? '') }}"
                class="pl-12 h-14 w-full rounded-xl border-2 border-gray-300 bg-white dark:bg-gray-800 px-4 py-3 text-lg font-semibold text-gray-800 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:outline-none transition-all duration-200 hover:border-gray-400" />
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
              💡 Tips: Jika outlet bernilai -1, otomatis akan menambahkan 'ne' di akhir
            </p>
          </div>
        </div>

        <!-- Form Footer -->
        <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
              
            </div>
            
            <div class="flex gap-3">
              <a href="{{ route('mip-lokasi-limbah') }}?date={{ $selectedDate }}"
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
                {{ isset($data_limbah) ? 'Update Data' : 'Simpan Data' }}
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
  // Validasi pH untuk input individual (tanpa pop-up)
  function validateSinglePH(input) {
    const value = parseFloat(input.value);
    
    if (input.value !== '') {
      if (isNaN(value) || value < 6 || value > 9) {
        // Ubah border menjadi merah
        input.classList.add('border-red-500');
        input.classList.remove('border-green-500');
        return false;
      } else {
        // Nilai valid - ubah border menjadi hijau
        input.classList.add('border-green-500');
        input.classList.remove('border-red-500');
        return true;
      }
    } else {
      // Reset border jika kosong
      input.classList.remove('border-red-500', 'border-green-500');
      return true;
    }
  }

  // Handle form submission dengan SweetAlert
  function handleFormSubmit(event) {
    event.preventDefault();
    
    const form = document.getElementById('limbahForm');
    const phInputs = [
      { element: form.querySelector('input[name="ph_inlet"]'), name: 'pH Inlet' },
      { element: form.querySelector('input[name="ph_outlet_1"]'), name: 'pH Outlet 1' },
      { element: form.querySelector('input[name="ph_outlet_2"]'), name: 'pH Outlet 2' }
    ];
    
    let invalidFields = [];
    let hasPhData = false;
    
    // Cek setiap field pH
    phInputs.forEach(field => {
      const value = parseFloat(field.element.value);
      
      if (field.element.value !== '') {
        hasPhData = true;
        if (isNaN(value) || value < 6 || value > 9) {
          invalidFields.push(field.name);
          field.element.classList.add('border-red-500');
          field.element.classList.remove('border-green-500');
        } else {
          field.element.classList.add('border-green-500');
          field.element.classList.remove('border-red-500');
        }
      }
    });
    
    // Jika ada field yang tidak valid
    if (invalidFields.length > 0) {
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        text: `Nilai pH tidak valid pada: ${invalidFields.join(', ')}. Rentang valid: 6.0 - 9.0`,
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

  // Auto-validate saat halaman dimuat (untuk edit form)
  document.addEventListener('DOMContentLoaded', function() {
    const phInputs = document.querySelectorAll('input[name="ph_inlet"], input[name="ph_outlet_1"], input[name="ph_outlet_2"]');
    
    phInputs.forEach(input => {
      if (input && input.value !== '') {
        validateSinglePH(input);
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
    background: linear-gradient(to right, #14b8a6, #06b6d4) !important;
  }
</style>
@endpush