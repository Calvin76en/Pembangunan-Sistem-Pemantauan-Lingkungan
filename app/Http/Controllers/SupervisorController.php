<?php

namespace App\Http\Controllers;

use App\Models\MonitoringType; // contoh model monitoring type

class SupervisorController extends Controller
{
    public function index()
    {
        // Ambil data monitoringTypes, sesuaikan dengan kebutuhan
        $monitoringTypes = MonitoringType::with('locations')->get();

        // Kirim ke view supervisor.dashboard
        return view('supervisor.dashboard', compact('monitoringTypes'));
    }
}
