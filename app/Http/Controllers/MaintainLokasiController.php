<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MaintainLokasiController extends Controller
{
    // Menampilkan halaman lokasi
    public function index()
    {
        return view('admin.maintainlokasi');
    }

    // Mengambil data lokasi dan monitoring types
    public function maintainlokasi()
    {
        // Get the locations with associated monitoring types
        $locations = DB::table('locations')
            ->join('monitoring_types', 'locations.monitoring_id', '=', 'monitoring_types.monitoring_id')
            ->select('locations.*', 'monitoring_types.monitoring_types') // Select the name of monitoring from monitoring_types
            ->orderBy('locations.location_name', 'asc')
            ->get();

        // Get all monitoring types for the dropdown in both "add" and "edit" modals
        $monitoringTypes = DB::table('monitoring_types')->get();

        // Count total locations
        $totalData = $locations->count();

        // Pass locations and monitoringTypes to the view
        return view('admin.maintainlokasi', compact('locations', 'totalData', 'monitoringTypes'));
    }


    // Menyimpan lokasi baru
    public function store(Request $request)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'location_name' => 'required|string|max:255',
            'monitoring_id' => 'nullable|exists:monitoring_types,monitoring_id',
            'status' => 'required|boolean',
        ]);

        // Periksa apakah lokasi dengan nama yang sama sudah ada (case-insensitive)
        $existingLocation = DB::table('locations')
            ->whereRaw('LOWER(location_name) = ?', [strtolower($validatedData['location_name'])])
            ->first();

        if ($existingLocation) {
            return redirect()->route('admin.maintainlokasi')->with('error', 'Lokasi dengan nama tersebut sudah ada!');
        }

        // Menyimpan data lokasi baru ke dalam database
        DB::table('locations')->insert([
            'location_name' => $validatedData['location_name'],
            'monitoring_id' => $validatedData['monitoring_id'],
            'status' => $validatedData['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kembali ke halaman dengan pesan sukses
        return redirect()->route('admin.maintainlokasi')->with('success', 'Lokasi berhasil ditambahkan!');
    }




    // Mengambil data lokasi untuk edit
    public function edit($location_id)
    {
        $location = DB::table('locations')->where('location_id', $location_id)->first();
        $monitoringTypes = DB::table('monitoring_types')->get();

        return view('admin.editlocation', compact('location', 'monitoringTypes'));
    }

    // Memperbarui data lokasi
    public function update(Request $request, $location_id)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'location_name' => 'required|string|max:255',
            'monitoring_id' => 'nullable|exists:monitoring_types,monitoring_id',
            'status' => 'required|boolean',
        ]);

        // Periksa apakah lokasi dengan nama yang sama sudah ada (case-insensitive) dan bukan lokasi yang sedang diedit
        $existingLocation = DB::table('locations')
            ->whereRaw('LOWER(location_name) = ?', [strtolower($validatedData['location_name'])])
            ->where('location_id', '<>', $location_id) // Pastikan bukan lokasi yang sedang diedit
            ->first();

        if ($existingLocation) {
            return redirect()->route('admin.maintainlokasi')->with('error', 'Lokasi dengan nama tersebut sudah ada!');
        }

        // Memperbarui data lokasi di database
        DB::table('locations')
            ->where('location_id', $location_id)
            ->update([
                'location_name' => $validatedData['location_name'],
                'monitoring_id' => $validatedData['monitoring_id'],
                'status' => $validatedData['status'],
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.maintainlokasi')->with('success', 'Lokasi berhasil diperbarui!');
    }

    // Menghapus lokasi
    public function destroy($location_id)
    {
        DB::table('locations')->where('location_id', $location_id)->delete();

        return redirect()->route('admin.maintainlokasi')->with('success', 'Lokasi berhasil dihapus!');
    }
}
