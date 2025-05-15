<?php

namespace App\Http\Controllers;

use App\Models\Kebisingan;
use Illuminate\Http\Request;
use App\Models\Location;

class KebisinganController extends Controller
{
    public function lokasiKebisingan()
    {
        // Mengambil semua data Kebisingan
        $lokasi_monitoring_kebisingan = Location::where('monitoring_id', 5)->get();

        return view('mip.lokasi-kebisingan', compact('lokasi_monitoring_kebisingan'));
    }

    public function tambah_kebisingan(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');
        return view('mip.kebisingan', compact('location_id', 'location_name', 'monitoring_type', 'monitoring_id'));
    }

    public function store_kebisingan(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'spl' => 'required|array',
            'location_id' => 'required|integer',
            'monitoring_id' => 'required|integer',
        ]);

        // Menyimpan setiap nilai SPL (L1 hingga L120)
        foreach ($validatedData['spl'] as $key => $value) {
            $second = 'L' . ($key + 1);  // L1, L2, ..., L120
            Kebisingan::create([
                'second' => $second,  // Menyimpan L1, L2, ..., L120
                'spl_db' => $value,   // Nilai SPL
                'location_id' => $validatedData['location_id'],
                'monitoring_id' => $validatedData['monitoring_id'],
            ]);
        }

        return redirect()->back()->with('success', 'Data Kebisingan berhasil disimpan.');
    }


}