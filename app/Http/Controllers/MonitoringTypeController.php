<?php

namespace App\Http\Controllers;

use App\Models\MonitoringType;

class MonitoringTypeController extends Controller
{
    // Menampilkan semua jenis pemantauan
    public function index()
    {
        // Ambil semua data monitoring types dengan lokasi yang memiliki status aktif (1)
        $monitoringTypes = MonitoringType::with(['locations' => function($query) {
            $query->where('status', 1); // Menampilkan hanya lokasi dengan status 1 (aktif)
        }])->get();

        // Kembalikan data ke view dengan nama 'monitoring-types'
        return view('monitoring-types.index', compact('monitoringTypes'));
    }

    // Menampilkan detail jenis pemantauan tertentu (optional)
    public function show($id)
    {
        // Ambil data jenis pemantauan berdasarkan ID
        $monitoringType = MonitoringType::with(['locations' => function($query) {
            $query->where('status', 1); // Menampilkan hanya lokasi dengan status 1 (aktif)
        }])->findOrFail($id);

        // Kembalikan data ke view dengan nama 'monitoring-types.show'
        return view('monitoring-types.show', compact('monitoringType'));
    }
}
