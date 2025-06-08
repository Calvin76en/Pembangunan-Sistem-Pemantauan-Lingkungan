@extends('layout.supervisor.dash')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
  <div class="p-6 mx-auto max-w-screen-xl">

    <!-- Bagian atas: Selamat Datang + gambar samping -->
    <div class="flex flex-col-reverse lg:flex-row items-center rounded-2xl shadow-lg p-8 gap-10">
      <div class="flex-1 max-w-lg">
        <h2 class="text-4xl font-bold mb-4">Selamat Datang di SIPALING</h2>
        <p class="text-blue-primary mb-1 text-xl">{{ Auth::user()->name }}</p>
        <!-- <p class="role-text">{{ Auth::user()->role }}</p> -->
      </div>

      <!-- Gambar samping (goal.png) -->
      <!-- <div class="flex-1 max-w-sm">
        <img src="{{ asset('assets/images/carousel/goal.png') }}" alt="Goal Illustration" class="w-full h-auto object-contain" />
      </div> -->
    </div>

  <div class="max-w-6xl mx-auto mt-10 bg-white rounded-xl shadow-md p-8 flex gap-6 items-start h-[364px]">

    <!-- Bagian kiri: Grid Gambar -->
    <div class="grid grid-cols-2 gap-6 w-[40%]">
      <!-- Gambar kiri atas -->
      <div class="overflow-hidden rounded-lg" style="height: 200px;">
        <img src="{{ asset('assets/images/carousel/gambar2.jpg') }}" alt="Gambar 1" class="w-full h-full object-cover" />
      </div>

      <!-- Gambar kanan tengah (besar dan tinggi) -->
      <div class="row-span-2 overflow-hidden rounded-lg" style="height: 320px;">
        <img src="{{ asset('assets/images/carousel/Pemantau.png') }}" alt="Pemantau" class="w-full h-full object-cover" />
      </div>

      <!-- Gambar kiri bawah -->
      <br><div class="overflow-hidden rounded-lg" style="height: 150px;margin-top:-120px">
        <img src="{{ asset('assets/images/carousel/tambang.jpg') }}" alt="Tambang" class="w-full h-full object-cover" />
      </div>
    </div>

    <!-- Bagian kanan: info -->
<div class="flex flex-col justify-start gap-10 w-[50%]">

  <!-- CARD LOKASI -->
  <div class="relative flex gap-6 items-start after:absolute after:bottom-0 after:right-0 after:w-12 after:border-b-2 after:border-r-2 after:border-gray-300 after:h-8">
    <!-- Kotak Angka -->
    <div class="flex flex-col items-center justify-center w-24 h-24 bg-white rounded-xl shadow-lg">
      <p class="text-[32px] leading-none font-black text-black">
        {{ $monitoringTypes->sum(function($monitoring) {
            return $monitoring->locations->where('status', 1)->count();
        }) }}
      </p>
      <span class="text-[13px] font-semibold text-gray-600 mt-1">Lokasi</span>
    </div>
    <!-- Teks -->
    <div>
      <h4 class="flex items-center gap-2 text-black font-bold text-[16px] leading-none">
        <i class="fas fa-map-marker-alt text-black text-lg"></i>
        Lokasi Pemantauan Aktif
      </h4>
      <p class="text-sm text-gray-700 mt-2 leading-relaxed max-w-xs">
        Total lokasi yang sedang dipantau dan dalam status aktif.
      </p>
    </div>
  </div>

  <!-- CARD TIPE PEMANTAUAN -->
  <div class="relative flex gap-6 items-start after:absolute after:bottom-0 after:right-0 after:w-12 after:border-b-2 after:border-r-2 after:border-gray-300 after:h-8">
    <!-- Kotak Angka -->
    <div class="flex flex-col items-center justify-center w-24 h-24 bg-white rounded-xl shadow-lg">
      <p class="text-[32px] leading-none font-black text-black">
        {{ $monitoringTypes->count() }}
      </p>
      <span class="text-[13px] font-semibold text-gray-600 mt-1">Pemantauan</span>
    </div>
    <!-- Teks -->
    <div>
      <h4 class="flex items-center gap-2 text-black font-bold text-[16px] leading-none">
        <i class="fas fa-cogs text-black text-lg"></i>
        Tipe Pemantauan
      </h4>
      <p class="text-sm text-gray-700 mt-2 leading-relaxed max-w-xs">
        Jenis pemantauan yang tersedia untuk limbah tambang.
      </p>
    </div>
  </div>

</div>


    

  </div>


    
  </div>
</main>

<!-- ===== Main Content End ===== -->
@endsection
