<?php

namespace App\Http\Controllers;

use App\Models\MonitoringType;
use App\Models\Location;
use App\Models\User;  // Pastikan model User ada
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        // Ambil data monitoring types beserta jumlah lokasi yang terkait
        $monitoringTypes = MonitoringType::withCount('locations')->get();
        
        // Ambil data location untuk lokasi dengan status aktif
        $locationsCount = Location::where('status', 1)->count();
        
        // Ambil total user
        $totalUsers = User::count();
    
        return view('admin.index', compact('monitoringTypes', 'locationsCount', 'totalUsers'));
    }

    public function indexMip()
    {
        // Ambil data monitoring types beserta jumlah lokasi yang terkait
        $monitoringTypes = MonitoringType::withCount('locations')->get();

        // Ambil data location untuk lokasi dengan status aktif
        $locationsCount = Location::where('status', 1)->count();

        // Ambil total user
        $totalUsers = User::count();

        // Kembalikan ke view dengan data yang diperlukan
        return view('mip.dashboard', compact('monitoringTypes', 'locationsCount', 'totalUsers'));
    }
     // Tambahan method untuk supervisor
    public function indexSupervisor()
    {
        // Contoh data yang sama, bisa disesuaikan jika berbeda kebutuhan
        $monitoringTypes = MonitoringType::withCount('locations')->get();
        $locationsCount = Location::where('status', 1)->count();
        $totalUsers = User::count();

        return view('supervisor.dashboard', compact('monitoringTypes', 'locationsCount', 'totalUsers'));
    }

}
