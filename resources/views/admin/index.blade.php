@extends('layout.admin.dash')
@section('content')


<div class="container mx-auto max-w-screen-xl px-4">
  <!-- Header -->

  <!-- Content -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center py-10">
    <!-- Image -->
    <div class="flex justify-center">
      <img src="{{ asset('assets/images/carousel/pekerja.png') }}"
           alt="Ilustrasi Pemantau"
           class="img-fluid rounded-4">
    </div>

    <!-- Text Content -->
    <div class="space-y-6">
      <h1 class="display-1 fs-1 font-bold text-gray-800" style="font-size: 4.5rem; font-weight: 700;">
        Premium <span class="text-red-500">Mining</span> Experience
      </h1>
      <p class="text-gray-600 text-lg">
        Behind every moment of mining activity, SIPALING stands as the ever-watchful eye—   observing, recording, and ensuring every step remains controlled, for a planet that keeps breathing.
      </p>

      <!-- Features -->
      <div style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 7  00px;">

  <!-- Feature 1 -->
    <div style="display: flex; align-items: flex-start; gap: 2rem;">
        <div style="
        width: 48px; height: 48px; 
        background: linear-gradient(135deg, #11B869, #0e944c); 
        border-radius: 12px 12px 12px 0; 
        box-shadow: 0 4px 12px rgba(17, 184, 105, 0.3); 
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        ">
        <i data-lucide="trending-up" class="text-white" style="font-size: 1.4rem;"></i>
        </div>
        <div>
        <h4 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 0.3rem;">Efficient Operations</h4>
        <p style="font-size: 1rem; color: #4b5563; line-height: 1.5;">
            Mining operations become more comfortable, optimized, and secure with our advanced monitoring system.
        </p>
        </div>
    </div>

    <!-- Feature 2 -->
    <div style="display: flex; align-items: flex-start; gap: 2rem;">
        <div style="
        width: 48px; height: 48px; 
        background: linear-gradient(135deg, #11B869, #0e944c); 
        border-radius: 12px 12px 12px 0; 
        box-shadow: 0 4px 12px rgba(17, 184, 105, 0.3); 
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        ">
        <i data-lucide="shield-check" class="text-white" style="font-size: 1.4rem;"></i>
        </div>
        <div>
        <h4 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 0.3rem;">Safe Monitoring</h4>
        <p style="font-size: 1rem; color: #4b5563; line-height: 1.5;">
            Your site is protected under vigilant and comprehensive monitoring. Every aspect is carefully overseen to maintain safety and prevent any potential hazards before they arise.
        </p>
        </div>
  </div>

</div>


  </div>
</div>
</div>
<!--end col-->

<!-- Container utama -->
<div class="grid grid-cols-12 gap-6 mt-12 mb-12 px-4 sm:px-6 lg:px-8">

  <!-- Lokasi Pemantauan Card -->
  <div class="col-span-12 sm:col-span-6 lg:col-span-4" data-aos="fade-up">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex flex-col items-center text-center
                shadow-lg shadow-gray-300/40 dark:shadow-black/40
                hover:shadow-xl hover:scale-105 transition duration-300 ease-in-out cursor-pointer">
      <div class="p-5 rounded-full mb-5 shadow-lg" style="background-color: #D3F5EE;">
        <i data-lucide="map-pin" class="w-12 h-12" style="color: #2F6D6D;"></i>
      </div>
      <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $locationsCount }}</h3>
      <p class="text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold text-sm sm:text-base">Lokasi Pemantauan</p>
      <small class="mt-2 text-gray-400 dark:text-gray-500">Jumlah lokasi yang dipantau secara aktif</small>
    </div>
  </div>

  <!-- Total User Card -->
  <div class="col-span-12 sm:col-span-6 lg:col-span-4" data-aos="fade-up" data-aos-delay="100">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex flex-col items-center text-center
                shadow-lg shadow-gray-300/40 dark:shadow-black/40
                hover:shadow-xl hover:scale-105 transition duration-300 ease-in-out cursor-pointer">
      <div class="bg-green-100 p-5 rounded-full mb-5 shadow-lg">
        <i data-lucide="user" class="w-12 h-12 text-green-600"></i>
      </div>
      <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $monitoringTypes->sum('locations_count') }}</h3>
      <p class="text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold text-sm sm:text-base">Total User</p>
      <small class="mt-2 text-gray-400 dark:text-gray-500">Pengguna yang terdaftar dalam sistem</small>
    </div>
  </div>

  <!-- Tipe Pemantauan Card -->
  <div class="col-span-12 sm:col-span-6 lg:col-span-4" data-aos="fade-up" data-aos-delay="200">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex flex-col items-center text-center
                shadow-lg shadow-gray-300/40 dark:shadow-black/40
                hover:shadow-xl hover:scale-105 transition duration-300 ease-in-out cursor-pointer">
      <div class="bg-green-100 p-5 rounded-full mb-5 shadow-lg">
        <i data-lucide="hard-hat" class="w-12 h-12 text-green-600"></i>
      </div>
      <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $monitoringTypes->count() }}</h3>
      <p class="text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold text-sm sm:text-base">Tipe Pemantauan</p>
      <small class="mt-2 text-gray-400 dark:text-gray-500">Jumlah kategori pemantauan yang tersedia</small>
    </div>
  </div>

</div>



{{-- pie card --}}

{{-- <div class="col-span-12 md:order-8 2xl:col-span-9 card">
    <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-4 text-15">Anggota</h6>
                <div id="simplePie" class="apex-charts"
                    data-chart-colors='["bg-custom-500", "bg-pink-500"]'
                    dir="ltr"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-4 text-15">Simple Donut</h6>
                <div id="simpleDonut" class="apex-charts"
                    data-chart-colors='["bg-custom-500", "bg-orange-500", "bg-green-500", "bg-sky-500", "bg-yellow-500"]'
                    dir="ltr"></div>
            </div>
        </div><!--end card-->
    </div><!--end grid-->
</div> --}}

<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button"
        class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>

<div id="customizerButton" drawer-end=""
    class="fixed inset-y-0 flex flex-col w-full transition-transform duration-300 ease-in-out transform bg-white shadow ltr:right-0 rtl:left-0 md:w-96 z-drawer show dark:bg-zink-600">
    <div class="flex justify-beSTEen p-4 border-b border-slate-200 dark:border-zink-500">
        <div class="grow">
            <h5 class="mb-1 text-16">PPTSB Theme Customizer</h5>
            <p class="font-normal text-slate-500 dark:text-zink-200">Choose your themes & layouts etc.</p>
        </div>
        <div class="shrink-0">
            <button data-drawer-close="customizerButton"
                class="transition-all duration-150 ease-linear text-slate-500 hover:text-slate-800 dark:text-zink-200 dark:hover:text-zink-50"><i
                    data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    </div>
    <div class="h-full p-6 overflow-y-auto">
        <div>
            <h5 class="mb-3 underline capitalize text-15">Choose Layouts</h5>
            <div class="grid grid-cols-1 mb-5 gap-7 sm:grid-cols-2">
                <div class="relative">
                    <input id="layout-one" name="dataLayout"
                        class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                        type="radio" value="vertical" checked="">
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500"
                        for="layout-one">
                        <span class="flex h-full gap-0">
                            <span class="shrink-0">
                                <span
                                    class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                    <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block h-3 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block h-3 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Vertical</h5>
                </div>

                <div class="relative">
                    <input id="layout-two" name="dataLayout"
                        class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                        type="radio" value="horizontal">
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500"
                        for="layout-two">
                        <span class="flex flex-col h-full gap-1">
                            <span class="flex items-center gap-1 p-1 bg-slate-100 dark:bg-zink-500">
                                <span class="block p-1 ml-1 bg-white rounded dark:bg-zink-500"></span>
                                <span class="block p-1 px-2 pb-0 bg-white dark:bg-zink-500 ms-auto"></span>
                                <span class="block p-1 px-2 pb-0 bg-white dark:bg-zink-500"></span>
                            </span>
                            <span class="block p-1 bg-slate-100 dark:bg-zink-500"></span>
                            <span class="block p-1 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Horizontal</h5>
                </div>
            </div>

            <div id="semi-dark">
                <div class="flex items-center">
                    <div class="relative inline-block w-10 mr-2 align-middle transition duration-200 ease-in">
                        <input type="checkbox" name="customDefaultSwitch" value="dark" id="customDefaultSwitch"
                            class="absolute block w-5 h-5 transition duration-300 ease-linear border-2 rounded-full appearance-none cursor-pointer border-slate-200 bg-white/80 peer/published checked:bg-white checked:right-0 checked:border-custom-500 arrow-none dark:border-zink-500 dark:bg-zink-500 dark:checked:bg-zink-400 checked:bg-none">
                        <label for="customDefaultSwitch"
                            class="block h-5 overflow-hidden transition duration-300 ease-linear border rounded-full cursor-pointer border-slate-200 bg-slate-200 peer-checked/published:bg-custom-500 peer-checked/published:border-custom-500 dark:border-zink-500 dark:bg-zink-600"></label>
                    </div>
                    <label for="customDefaultSwitch" class="inline-block text-base font-medium">Semi Dark (Sidebar &
                        Header)</label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-skin="" -->
            <h5 class="mb-3 underline capitalize text-15">Skin Layouts</h5>
            <div class="grid grid-cols-1 mb-5 gap-7 sm:grid-cols-2">
                <div class="relative">
                    <input id="layoutSkitOne" name="dataLayoutSkin"
                        class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                        type="radio" value="default">
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600"
                        for="layoutSkitOne">
                        <span class="flex h-full gap-0">
                            <span class="shrink-0">
                                <span
                                    class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                    <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block h-3 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block h-3 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Default</h5>
                </div>

                <div class="relative">
                    <input id="layoutSkitTwo" name="dataLayoutSkin"
                        class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                        type="radio" value="bordered" checked="">
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500"
                        for="layoutSkitTwo">
                        <span class="flex h-full gap-0">
                            <span class="shrink-0">
                                <span
                                    class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                    <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block h-3 border-b border-slate-200 dark:border-zink-500"></span>
                                    <span
                                        class="block h-3 mt-auto border-t border-slate-200 dark:border-zink-500"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Bordered</h5>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-mode="" -->
            <h5 class="mb-3 underline capitalize text-15">Light & Dark</h5>
            <div class="flex gap-3">
                <button type="button" id="dataModeOne" name="dataMode" value="light"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Light
                    Mode</button>
                <button type="button" id="dataModeTwo" name="dataMode" value="dark"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Dark
                    Mode</button>
            </div>
        </div>

        <div class="mt-6">
            <!-- dir="ltr" -->
            <h5 class="mb-3 underline capitalize text-15">LTR & RTL</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="diractionOne" name="dir" value="ltr"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">LTR
                    Mode</button>
                <button type="button" id="diractionTwo" name="dir" value="rtl"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">RTL
                    Mode</button>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-content -->
            <h5 class="mb-3 underline capitalize text-15">Content Width</h5>
            <div class="flex gap-3">
                <button type="button" id="datawidthOne" name="datawidth" value="fluid"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Fluid</button>
                <button type="button" id="datawidthTwo" name="datawidth" value="boxed"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Boxed</button>
            </div>
        </div>

        <div class="mt-6" id="sidebar-size">
            <!-- data-sidebar-size="" -->
            <h5 class="mb-3 underline capitalize text-15">Sidebar Size</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="sidebarSizeOne" name="sidebarSize" value="lg"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Default</button>
                <button type="button" id="sidebarSizeTwo" name="sidebarSize" value="md"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Compact</button>
                <button type="button" id="sidebarSizeThree" name="sidebarSize" value="sm"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Small
                    (Icon)</button>
            </div>
        </div>

        <div class="mt-6" id="navigation-type">
            <!-- data-navbar="" -->
            <h5 class="mb-3 underline capitalize text-15">Navigation Type</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="navbarTwo" name="navbar" value="sticky"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Sticky</button>
                <button type="button" id="navbarOne" name="navbar" value="scroll"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Scroll</button>
                <button type="button" id="navbarThree" name="navbar" value="bordered"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Bordered</button>
                <button type="button" id="navbarFour" name="navbar" value="hidden"
                    class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Hidden</button>
            </div>
        </div>

        <div class="mt-6" id="sidebar-color">
            <!-- data-sidebar="" light, dark, brand, modern-->
            <h5 class="mb-3 underline capitalize text-15">Sizebar Colors</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="sidebarColorOne" name="sidebarColor" value="light"
                    class="flex items-center justify-center w-10 h-10 bg-white border rounded-md border-slate-200 group active"><i
                        data-lucide="check"
                        class="w-5 h-5 hidden group-[.active]:inline-block text-slate-600"></i></button>
                <button type="button" id="sidebarColorTwo" name="sidebarColor" value="dark"
                    class="flex items-center justify-center w-10 h-10 border rounded-md border-zink-900 bg-zink-900 group"><i
                        data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                <button type="button" id="sidebarColorThree" name="sidebarColor" value="brand"
                    class="flex items-center justify-center w-10 h-10 border rounded-md border-custom-800 bg-custom-800 group"><i
                        data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                <button type="button" id="sidebarColorFour" name="sidebarColor" value="modern"
                    class="flex items-center justify-center w-10 h-10 border rounded-md border-purple-950 bg-gradient-to-t from-red-400 to-purple-500 group"><i
                        data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-topbar="" light, dark, brand, modern-->
            <h5 class="mb-3 underline capitalize text-15">Topbar Colors</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="topbarColorOne" name="topbarColor" value="light"
                    class="flex items-center justify-center w-10 h-10 bg-white border rounded-md border-slate-200 group active"><i
                        data-lucide="check"
                        class="w-5 h-5 hidden group-[.active]:inline-block text-slate-600"></i></button>
                <button type="button" id="topbarColorTwo" name="topbarColor" value="dark"
                    class="flex items-center justify-center w-10 h-10 border rounded-md border-zink-900 bg-zink-900 group"><i
                        data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                <button type="button" id="topbarColorThree" name="topbarColor" value="brand"
                    class="flex items-center justify-center w-10 h-10 border rounded-md border-custom-800 bg-custom-800 group"><i
                        data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
            </div>
        </div>

    </div>
    <div class="flex items-center justify-beSTEen gap-3 p-4 border-t border-slate-200 dark:border-zink-500">
        <button type="button" id="reset-layout"
            class="w-full transition-all duration-200 ease-linear text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100">Reset</button>
        <a href="#!"
            class="w-full text-white transition-all duration-200 ease-linear bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100">Buy
            Now</a>
    </div>
</div>





@endsection



