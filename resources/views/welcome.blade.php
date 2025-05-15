<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SiPaling</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-white text-gray-700 font-sans">


  <!-- Konten Utama -->
  <main class="flex-grow">
    <!-- Header -->
    <div class="relative">
      <img src="/assets/images/header.jpg" alt="Header Image" class="w-full h-64 object-cover" />
    </div>

      <!-- Overlay Card Section -->
      <div class="relative z-10 -mt-20 mx-auto bg-white w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 pb-10 rounded-[50px] text-center shadow-md">

        <h1 class="text-4xl md:text-5xl font-bold mt-8">
          <span class="text-lime-600">Si</span><span class="text-black">Paling</span>
        </h1>
        <p class="text-gray-500 text-sm mt-2">Sistem Pemantauan Lingkungan</p>

        <!-- Cards -->
        <div class="flex flex-col md:flex-row justify-center gap-6 mt-10 px-6">
          <!-- Card 1 -->
          <div class="bg-lime-100 p-6 rounded-xl w-full md:w-1/2 lg:max-w-xs">
            <h2 class="text-md font-bold mb-2">Pemantauan Harian</h2>
            <p class="text-sm">Laporan otomatis dan terkini tentang kualitas udara, kebisingan, serta parameter lingkungan lainnya di area operasional.</p>
          </div>
          <!-- Card 2 -->
          <div class="bg-lime-100 p-6 rounded-xl w-full md:w-1/2 lg:max-w-xs">
            <h2 class="text-md font-bold mb-2">Rekap Bulanan</h2>
            <p class="text-sm">Rangkuman data pemantauan yang telah tervalidasi, siap untuk ditinjau dan digunakan dalam proses evaluasi lingkungan.</p>
          </div>
        </div>

        <!-- Tombol Login -->
        <div class="mt-8">
          <a href="/login" class="bg-lime-600 hover:bg-lime-700 text-white font-semibold px-10 py-2 rounded-full transition">
            Login
          </a>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 py-10 text-center text-sm text-gray-600">
    <div class="max-w-6xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-6 text-left">
        <!-- Kolom 1 -->
        <div>
          <h3 class="font-bold text-gray-800 mb-2">Tentang SiPaling</h3>
          <p>Platform pemantauan lingkungan digital yang menyediakan data realtime dan laporan evaluatif berkala.</p>
        </div>
        <!-- Kolom 2 -->
        <div>
          <h3 class="font-bold text-gray-800 mb-2">Navigasi</h3>
          <ul class="space-y-1">
            <li><a href="/" class="hover:underline">Beranda</a></li>
            <li><a href="/login" class="hover:underline">Login</a></li>
            <li><a href="/kontak" class="hover:underline">Kontak</a></li>
          </ul>
        </div>
        <!-- Kolom 3 -->
        <div>
          <h3 class="font-bold text-gray-800 mb-2">Kontak</h3>
          <p>Email: support@sipaling.com</p>
          <p>Telepon: (021) 123-4567</p>
          <p>Alamat: Jakarta, Indonesia</p>
        </div>
      </div>

      <hr class="my-4" />
      <p class="text-xs text-gray-500">&copy; 2025 SiPaling. Semua hak dilindungi undang-undang.</p>
    </div>
  </footer>

</body>
</html>
