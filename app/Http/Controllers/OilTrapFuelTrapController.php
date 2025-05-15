<?php

namespace App\Http\Controllers;

use App\Models\OilTrapFuelTrap;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class OilTrapFuelTrapController extends Controller
{
    // Menampilkan data lokasi limbah tambang
    public function lokasiOilFuel()
    {
        // Mengambil data lokasi limbah tambang yang terkait dengan monitoring_id 2
        $lokasi_monitoring_oilfuel = Location::where('monitoring_id', 2)->get();

        // Mengirim data lokasi ke view 'mip.lokasi-limbah'
        return view('mip.lokasi-oilfuel', compact('lokasi_monitoring_oilfuel'));
    }

    // Menampilkan form untuk menambahkan data pemantauan air limbah


    public function tambah_oilfuel(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');

        // Cek apakah data sudah ada
        $existingData = OilTrapFuelTrap::where('location_id', $location_id)->first();

        return view('mip.oilfuel-trap', compact(
            'location_id',
            'location_name',
            'monitoring_type',
            'monitoring_id',
            'existingData' // kirim ke view
        ));
    }

    public function store_oilfuel(Request $request)
    {
        $validatedData = $request->validate([
            'ph' => 'required|numeric',
            'location_id' => 'required|integer',
            'monitoring_id' => 'required|integer',
        ]);

        // Cek apakah data sudah ada
        $existing = OilTrapFuelTrap::where('location_id', $validatedData['location_id'])->first();

        if ($existing) {
            $existing->update($validatedData);
        } else {
            OilTrapFuelTrap::create($validatedData);
        }

        DB::table('locations')
            ->where('location_id', $validatedData['location_id'])
            ->update(['keterangan' => 'Completed']);

        return redirect()->route('lokasi-oilfuel')
            ->with('success', 'Data berhasil disimpan/diperbarui.');
    }


    public function edit_oilfuel(Request $request)
    {
        $location_id = $request->query('location_id');
        $location = Location::with('monitoringType')->where('location_id', $location_id)->first();
        $existingData = OilTrapFuelTrap::where('location_id', $location_id)->first();

        return view('mip.oilfuel-trap', [
            'location_id' => $location->location_id,
            'location_name' => $location->location_name,
            'monitoring_type' => $location->monitoringType->monitoring_types,
            'monitoring_id' => $location->monitoring_id,
            'existingData' => $existingData,
            'editMode' => true, // penanda sedang edit
        ]);
    }
}
