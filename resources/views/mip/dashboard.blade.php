@extends('layout.mip.dash')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
  <div class="p-4 mx-auto max-w-screen-xl md:p-6">

    <!-- Card Header -->
    <div class="rounded-2xl border mx-auto border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
          Dashboard
        </h3>
      </div>
      <div class="border-t border-gray-100 p-4 dark:border-gray-800 sm:p-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Gambar pertama -->
          <div class="overflow-hidden rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <img src="{{ asset('assets/images/carousel/gambar1.jpg') }}" alt="image grid" class="w-full h-60 object-cover" />
          </div>


          <!-- Gambar kedua -->
          <div class="overflow-hidden rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <img src="{{ asset('assets/images/carousel/gambar2.jpg') }}" alt="image grid"
              class="w-full h-60 object-cover" />
          </div>
        </div>
      </div>
    </div>

    <!-- Teks Selamat Datang -->
    <div class="mt-8">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Selamat Datang di SiPaling</h2>
      <p class="text-lg mt-2 text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</p>
      <p class="text-md text-gray-500 dark:text-gray-400">{{ Auth::user()->role }}</p>
    </div>

    <!-- Card pertama: Total lokasi aktif -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
      <!-- Card pertama: Total lokasi aktif -->
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transition-transform ">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-2xl font-semibold text-gray-800 dark:text-white">
              {{ $monitoringTypes->sum(function($monitoring) {
                return $monitoring->locations->where('status', 1)->count();
              }) }}
            </p>
            <h4 class="text-xl font-semibold text-gray-800 dark:text-white mt-3">Lokasi Pemantauan</h4>
          </div>
          <div class="bg-[#84A647] p-4 rounded-full text-white">
            <i class="fas fa-map-marker-alt text-3xl"></i>
          </div>
        </div>
      </div>

      <!-- Card kedua: Jumlah tipe pemantauan -->
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-2xl font-semibold font-extrabold text-gray-800 dark:text-white">
              {{ $monitoringTypes->count() }}
            </p>
            <h4 class="text-xl font-semibold text-gray-800 dark:text-white mt-3">Tipe Pemantauan</h4>
          </div>
          <div class="bg-[#11B869] p-4 rounded-full text-white">
            <i class="fas fa-cogs text-3xl"></i>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>
<!-- ===== Main Content End ===== -->
@endsection
