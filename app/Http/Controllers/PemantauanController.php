<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class PemantauanController extends Controller
{
    // Menampilkan halaman curah hujan
    public function curahHujan()
    {
        return view('mip.curah-hujan');  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan halaman debu
    public function debu()
    {
        return view('mip.debu');  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan halaman kebisingan
    public function kebisingan()
    {
        return view('mip.kebisingan');  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan halaman limbah tambang
    public function limbahTambang()
    {
        dd(1);
        // return view(view: 'mip.limbah-tambang');  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan halaman oil fuel trap
    public function oilfuelTrap()
    {
        return view('mip.oilfuel-trap');  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan lokasi curah hujan
    public function lokasiCurah()
    {
        $lokasi_monitoring_curah_hujan = Location::where('monitoring_id', 3)
                                                 ->where('status', 1)  // Menambahkan kondisi status = 1
                                                 ->get();
        return view('mip.lokasi-curah', compact('lokasi_monitoring_curah_hujan'));  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan lokasi debu
    public function lokasiDebu()
    {
        $lokasi_monitoring_debu = Location::where('monitoring_id', 4)
                                          ->where('status', 1)  // Menambahkan kondisi status = 1
                                          ->get();
        return view('mip.lokasi-debu', compact('lokasi_monitoring_debu'));  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan lokasi kebisingan
    public function lokasiKebisingan()
    {
        $lokasi_monitoring_kebisingan = Location::where('monitoring_id', 5)
                                                 ->where('status', 1)  // Menambahkan kondisi status = 1
                                                 ->get();
        return view('mip.lokasi-kebisingan', compact('lokasi_monitoring_kebisingan'));  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan lokasi limbah
    public function lokasiLimbah()
    {
        // Mengambil lokasi limbah tambang dengan status aktif (status = 1)
        $lokasi_monitoring_limbah_tambang = Location::where('monitoring_id', 1)
                                                    ->where('status', 1)  // Menambahkan kondisi status = 1
                                                    ->get();

        // Mengirim data lokasi ke view
        return view('mip.lokasi-limbah', compact('lokasi_monitoring_limbah_tambang'));  // Sesuaikan dengan path di folder mip
    }

    // Menampilkan lokasi oil fuel
    public function lokasiOilfuel()
    {
        $lokasi_monitoring_oilfuel = Location::where('monitoring_id', 2)
                                             ->where('status', 1)  // Menambahkan kondisi status = 1
                                             ->get();
        return view('mip.lokasi-oilfuel', compact('lokasi_monitoring_oilfuel'));  // Sesuaikan dengan path di folder mip
    }
}
