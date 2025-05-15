<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    // Menampilkan lokasi-lokasi berdasarkan monitoring type yang dipilih
    public function showLimbahTambang(Request $request)
    {
        // Ambil nilai monitoring_id dari request, jika tidak ada, defaultkan ke 1 (Air Limbah Tambang)
        $monitoring_id = $request->input('monitoring_id', 1);

        // Ambil data lokasi berdasarkan monitoring_id yang dipilih
        $locations = Location::where('monitoring_id', $monitoring_id)->get();

        // Kembalikan data ke view dengan nama 'limbah-tambang'
        return view('limbah-tambang', compact('locations'));
    }
}
