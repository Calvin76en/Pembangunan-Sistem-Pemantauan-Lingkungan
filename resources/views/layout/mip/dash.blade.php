<!doctype html>
<html lang="en">

<!-- Mirrored from demo.tailadmin.com/basic-tables by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Apr 2025 05:55:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        SIPALING
    </title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <link rel="icon" href="favicon.ico">
    <link href="{{ asset('assets\css\style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script data-cfasync="false" nonce="bc477361-dd6a-4769-8f05-32afd2c18318">
        try {
            (function(w, d) {
                ! function(j, k, l, m) {
                    if (j.zaraz) console.error("zaraz is loaded twice");
                    else {
                        j[l] = j[l] || {};
                        j[l].executed = [];
                        j.zaraz = {
                            deferred: [],
                            listeners: []
                        };
                        j.zaraz._v = "5850";
                        j.zaraz._n = "bc477361-dd6a-4769-8f05-32afd2c18318";
                        j.zaraz.q = [];
                        j.zaraz._f = function(n) {
                            return async function() {
                                var o = Array.prototype.slice.call(arguments);
                                j.zaraz.q.push({
                                    m: n,
                                    a: o
                                })
                            }
                        };
                        for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
                        j.zaraz.init = () => {
                            var q = k.getElementsByTagName(m)[0],
                                r = k.createElement(m),
                                s = k.getElementsByTagName("title")[0];
                            s && (j[l].t = k.getElementsByTagName("title")[0].text);
                            j[l].x = Math.random();
                            j[l].w = j.screen.width;
                            j[l].h = j.screen.height;
                            j[l].j = j.innerHeight;
                            j[l].e = j.innerWidth;
                            j[l].l = j.location.href;
                            j[l].r = k.referrer;
                            j[l].k = j.screen.colorDepth;
                            j[l].n = k.characterSet;
                            j[l].o = (new Date).getTimezoneOffset();
                            if (j.dataLayer)
                                for (const t of Object.entries(Object.entries(dataLayer).reduce(((u, v) => ({
                                        ...u[1],
                                        ...v[1]
                                    })), {}))) zaraz.set(t[0], t[1], {
                                    scope: "page"
                                });
                            j[l].q = [];
                            for (; j.zaraz.q.length;) {
                                const w = j.zaraz.q.shift();
                                j[l].q.push(w)
                            }
                            r.defer = !0;
                            for (const x of [localStorage, sessionStorage]) Object.keys(x || {}).filter((z => z.startsWith("_zaraz_"))).forEach((y => {
                                try {
                                    j[l]["z_" + y.slice(7)] = JSON.parse(x.getItem(y))
                                } catch {
                                    j[l]["z_" + y.slice(7)] = x.getItem(y)
                                }
                            }));
                            r.referrerPolicy = "origin";
                            r.src = "cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(j[l])));
                            q.parentNode.insertBefore(r, q)
                        };
                        ["complete", "interactive"].includes(k.readyState) ? zaraz.init() : j.addEventListener("DOMContentLoaded", zaraz.init)
                    }
                }(w, d, "zarazData", "script");
                window.zaraz._p = async bs => new Promise((bt => {
                    if (bs) {
                        bs.e && bs.e.forEach((bu => {
                            try {
                                const bv = d.querySelector("script[nonce]"),
                                    bw = bv?.nonce || bv?.getAttribute("nonce"),
                                    bx = d.createElement("script");
                                bw && (bx.nonce = bw);
                                bx.innerHTML = bu;
                                bx.onload = () => {
                                    d.head.removeChild(bx)
                                };
                                d.head.appendChild(bx)
                            } catch (by) {
                                console.error(`Error executing script: ${bu}\n`, by)
                            }
                        }));
                        Promise.allSettled((bs.f || []).map((bz => fetch(bz[0], bz[1]))))
                    }
                    bt()
                }));
                zaraz._p({
                    "e": ["(function(w,d){})(window,document)"]
                });
            })(window, document)
        } catch (e) {
            throw fetch("/cdn-cgi/zaraz/t"), e;
        };
    </script>
</head>

<body
    x-data="{  
        page: '{{ Route::currentRouteName() }}', 
        'loaded': true, 
        'darkMode': false, 
        'stickyMenu': false, 
        'sidebarToggle': false, 
        'scrollTop': false 
    }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">

    <!-- ===== Preloader Start ===== -->
    <div
        x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div
            class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
    </div>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <aside
            :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
            class="sidebar fixed top-0 left-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-auto border-r border-gray-200 bg-white px-5 transition-all duration-300 lg:static lg:translate-x-0 dark:border-gray-800 dark:bg-black"
            @click.outside="sidebarToggle = false">

            <!-- SIDEBAR HEADER -->
            <div
                :class="sidebarToggle ? 'justify-center' : 'justify-between'"
                class="sidebar-header flex items-center gap-2 pt-8 pb-7">
                <a href="{{ route('mip.dashboard') }}" class="flex flex-col items-center">
                    <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                        <img class="dark:hidden" src="{{ asset('assets/images/logo/sipaling.jpg') }}" alt="Logo" />
                        <img class="hidden dark:block" src="{{ asset('assets/images/logo/auth-logo.svg') }}" alt="Logo" />
                    </span>

                    <img
                        class="logo-icon"
                        :class="sidebarToggle ? 'lg:block' : 'hidden'"
                        src="{{ asset('assets/images/logo/sipaling.jpg') }}"
                        alt="Logo" />

                    <!-- Teks Sistem Pemantauan Lingkungan -->
                    <div
                        class="mt-2 text-center leading-tight"
                        :class="sidebarToggle ? 'hidden' : ''">
                        <div class="text-sm font-semibold">
                            <span style="color: rgba(159, 197, 78, 1);">Sistem</span>
                            <span class="text-gray-700 dark:text-gray-200 ml-1">Pemantauan Lingkungan</span>
                        </div>
                    </div>
                </a>
            </div>
            <!-- SIDEBAR HEADER -->

            <div
                class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
                <!-- Sidebar Menu -->
                <nav x-data="{
                    selected: $persist(
                        (() => {
                            // Tentukan menu mana yang harus terbuka berdasarkan route
                            const currentRoute = '{{ Route::currentRouteName() }}';
                            const formRoutes = ['mip-lokasi-limbah', 'lokasi-oilfuel', 'lokasi-curah', 'mip-lokasi-debu', 'lokasi-kebisingan'];
                            
                            if (formRoutes.includes(currentRoute)) {
                                return 'Forms';
                            }
                            return 'Dashboard';
                        })()
                    )
                }">
                    <!-- Menu Group -->
                    <div>
                        <h3 class="mb-4 text-xs leading-[20px] text-gray-400 uppercase">
                            <span
                                class="menu-group-title"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                MENU
                            </span>

                            <svg
                                :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                                class="menu-group-icon mx-auto fill-current"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                                    fill="" />
                            </svg>
                        </h3>

                        <ul class="mb-6 flex flex-col gap-4">
                            <!-- Menu Item Dashboard -->
                            <li>
                                <a
                                    href="{{ route('mip.dashboard') }}"
                                    class="menu-item group"
                                    :class="(page === 'mip.dashboard') ? 'menu-item-active' : 'menu-item-inactive'">
                                    <svg
                                        :class="(page === 'mip.dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect
                                            x="3"
                                            y="3"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            fill="none" />
                                        <rect
                                            x="14"
                                            y="3"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            fill="none" />
                                        <rect
                                            x="3"
                                            y="14"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            fill="none" />
                                        <rect
                                            x="14"
                                            y="14"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            fill="none" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Beranda
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Dashboard -->

                            <!-- Menu Item Forms -->
                            <li>
                                @php
                                $formRoutes = ['mip-lokasi-limbah', 'lokasi-oilfuel', 'lokasi-curah', 'mip-lokasi-debu', 'lokasi-kebisingan'];
                                $isFormActive = in_array(Route::currentRouteName(), $formRoutes);
                                @endphp

                                <a
                                    href="#"
                                    @click.prevent="selected = (selected === 'Forms' ? '':'Forms')"
                                    class="menu-item group"
                                    :class="@json($isFormActive) ? 'menu-item-active' : 'menu-item-inactive'">
                                    <svg
                                        :class="@json($isFormActive) ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                            fill="" />
                                    </svg>

                                    <span
                                        class="menu-item-text"
                                        :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Form Pemantauan
                                    </span>

                                    <svg
                                        class="menu-item-arrow absolute top-1/2 right-2.5 -translate-y-1/2 stroke-current"
                                        :class="[(selected === 'Forms') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                                            stroke=""
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>

                                <!-- Dropdown Menu Start -->
                                <div x-show="selected === 'Forms'" class="translate transform overflow-hidden">
                                    <ul class="menu-dropdown mt-2 flex flex-col gap-1 pl-9">
                                        <!-- Menu Items with Active Class Based on Page -->
                                        <li>
                                            <a href="{{ route('mip-lokasi-limbah') }}"
                                                class="menu-dropdown-item group"
                                                :class="(page === 'mip-lokasi-limbah') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                                Air Limbah Tambang
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('lokasi-oilfuel') }}"
                                                class="menu-dropdown-item group"
                                                :class="(page === 'lokasi-oilfuel') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                                Oil Trap & Fuel Trap
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('lokasi-curah') }}"
                                                class="menu-dropdown-item group"
                                                :class="(page === 'lokasi-curah') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                                Curah Hujan
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('mip-lokasi-debu') }}"
                                                class="menu-dropdown-item group"
                                                :class="(page === 'mip-lokasi-debu') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                                Debu
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('lokasi-kebisingan') }}"
                                                class="menu-dropdown-item group"
                                                :class="(page === 'lokasi-kebisingan') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                                Kebisingan
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Dropdown Menu End -->
                            </li>

                            <!-- Menu Item Print Report -->
                            <li>
                                <a
                                    href="{{ route('print.report') }}"
                                    class="menu-item group"
                                    :class="(page === 'print.report') ? 'menu-item-active' : 'menu-item-inactive'">
                                    <svg
                                        :class="(page === 'print.report') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6v-8Z"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            fill="none" />
                                        <circle cx="17" cy="11" r="1" stroke="currentColor" stroke-width="1" fill="none" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Cetak Laporan
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Print Report -->
                        </ul>
                    </div>
                </nav>
            </div>
        </aside>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div
            class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            <!-- Small Device Overlay Start -->
            <div
                :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                class="fixed z-9 h-screen w-full bg-gray-900/50"></div>
            <!-- Small Device Overlay End -->

            <!-- ===== Header Start ===== -->
            <header
                x-data="{menuToggle: false}"
                class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 lg:border-b">
                <div
                    class="flex grow flex-col items-center justify-between lg:flex-row lg:px-6">
                    <div
                        class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 dark:border-gray-800 sm:gap-4 lg:justify-normal lg:border-b-0 lg:px-0 lg:py-4">
                        <!-- Hamburger Toggle BTN -->
                        <button
                            :class="sidebarToggle ? 'lg:bg-transparent dark:lg:bg-transparent bg-gray-100 dark:bg-gray-800' : ''"
                            class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 dark:border-gray-800 dark:text-gray-400 lg:h-11 lg:w-11 lg:border"
                            @click.stop="sidebarToggle = !sidebarToggle">
                            <svg
                                class="hidden fill-current lg:block"
                                width="16"
                                height="12"
                                viewBox="0 0 16 12"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
                                    fill="" />
                            </svg>

                            <svg
                                :class="sidebarToggle ? 'hidden' : 'block lg:hidden'"
                                class="fill-current lg:hidden"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
                                    fill="" />
                            </svg>

                            <!-- cross icon -->
                            <svg
                                :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                                class="fill-current"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                                    fill="" />
                            </svg>
                        </button>
                        <!-- Hamburger Toggle BTN -->

                        <a href="index.html" class="lg:hidden">
                            <img class="dark:hidden" src="src/images/logo/logo.svg" alt="Logo" />
                            <img
                                class="hidden dark:block"
                                src="src/images/logo/logo-dark.svg"
                                alt="Logo" />
                        </a>

                        <!-- Application nav menu button -->
                        <button
                            class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 lg:hidden"
                            :class="menuToggle ? 'bg-gray-100 dark:bg-gray-800' : ''"
                            @click.stop="menuToggle = !menuToggle">
                            <svg
                                class="fill-current"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
                                    fill="" />
                            </svg>
                        </button>
                        <!-- Application nav menu button -->
                    </div>

                    <div
                        :class="menuToggle ? 'flex' : 'hidden'"
                        class="w-full items-center justify-between gap-4 px-5 py-4 shadow-theme-md lg:flex lg:justify-end lg:px-0 lg:shadow-none">

                        <!-- User Area -->
                        <div
                            class="relative"
                            x-data="{ dropdownOpen: false }"
                            @click.outside="dropdownOpen = false">
                            <a
                                class="flex items-center text-gray-700 dark:text-gray-400"
                                href="#"
                                @click.prevent="dropdownOpen = ! dropdownOpen">

                                <span class="mr-1 block text-theme-sm font-medium">
                                    {{ Auth::user()->name }}
                                </span>

                                <svg
                                    :class="dropdownOpen && 'rotate-180'"
                                    class="stroke-gray-500 dark:stroke-gray-400"
                                    width="18"
                                    height="20"
                                    viewBox="0 0 18 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.3125 8.65625L9 13.3437L13.6875 8.65625"
                                        stroke=""
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Start -->
                            <div
                                x-show="dropdownOpen"
                                class="absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark">
                                <div>
                                    <span class="block text-theme-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ Auth::user()->name }}
                                    </span>

                                    <span
                                        class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400">
                                        <a href="mailto:{{ Auth::user()->email }}" class="text-blue-500">
                                            {{ Auth::user()->email }}
                                        </a>
                                    </span>
                                </div>

                                <ul
                                    class="flex flex-col gap-1 border-b border-gray-200 pb-3 pt-4 dark:border-gray-800">
                                </ul>

                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="group mt-3 flex items-center gap-3 rounded-lg px-3 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                        <svg
                                            class="fill-gray-500 group-hover:fill-gray-700 dark:group-hover:fill-gray-300"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M15.1007 19.247C14.6865 19.247 14.3507 18.9112 14.3507 18.497L14.3507 14.245H12.8507V18.497C12.8507 19.7396 13.8581 20.747 15.1007 20.747H18.5007C19.7434 20.747 20.7507 19.7396 20.7507 18.497L20.7507 5.49609C20.7507 4.25345 19.7433 3.24609 18.5007 3.24609H15.1007C13.8581 3.24609 12.8507 4.25345 12.8507 5.49609V9.74501L14.3507 9.74501V5.49609C14.3507 5.08188 14.6865 4.74609 15.1007 4.74609L18.5007 4.74609C18.9149 4.74609 19.2507 5.08188 19.2507 5.49609L19.2507 18.497C19.2507 18.9112 18.9149 19.247 18.5007 19.247H15.1007ZM3.25073 11.9984C3.25073 12.2144 3.34204 12.4091 3.48817 12.546L8.09483 17.1556C8.38763 17.4485 8.86251 17.4487 9.15549 17.1559C9.44848 16.8631 9.44863 16.3882 9.15583 16.0952L5.81116 12.7484L16.0007 12.7484C16.4149 12.7484 16.7507 12.4127 16.7507 11.9984C16.7507 11.5842 16.4149 11.2484 16.0007 11.2484L5.81528 11.2484L9.15585 7.90554C9.44864 7.61255 9.44847 7.13767 9.15547 6.84488C8.86248 6.55209 8.3876 6.55226 8.09481 6.84525L3.52309 11.4202C3.35673 11.5577 3.25073 11.7657 3.25073 11.9984Z"
                                                fill="" />
                                        </svg>

                                        Sign out
                                    </button>
                                </form>
                            </div>
                            <!-- Dropdown End -->
                        </div>
                        <!-- User Area -->
                    </div>
                </div>
            </header>
            <!-- ===== Header End ===== -->

            @yield('content')

        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script defer src="{{ asset('assets/js/bundle.js') }}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"93535a1dbe5cffe4","version":"2025.4.0-1-g37f21b1","r":1,"serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"67f7a278e3374824ae6dd92295d38f77","b":1}'
        crossorigin="anonymous"></script>
    <!-- existing scripts -->
    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script defer src="{{ asset('assets/js/bundle.js') }}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/…"></script>

    @stack('scripts')

</body>

</html>

</body>

<!-- Mirrored from demo.tailadmin.com/carousel by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Apr 2025 05:56:09 GMT -->

</html>