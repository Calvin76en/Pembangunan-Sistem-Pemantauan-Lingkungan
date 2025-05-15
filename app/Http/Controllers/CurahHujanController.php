<?php

namespace App\Http\Controllers;

use App\Models\CurahHujan;
use App\Models\Location;
use Illuminate\Http\Request;


class CurahHujanController extends Controller
{
    // Menampilkan data lokasi limbah tambang
    public function lokasiCurah()
    {
        $lokasi_monitoring_curah = Location::where('monitoring_id', 3)
            ->with('monitoringType')
            ->get();

        return view('mip.lokasi-curah', compact('lokasi_monitoring_curah'));
    }


    // Menampilkan form untuk menambahkan data pemantauan air limbah


    public function tambah_curah(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');

        // Ambil data curah hujan terakhir untuk lokasi tersebut (jika ada)
        $data_limbah = CurahHujan::where('location_id', $location_id)
            ->orderByDesc('created_at')
            ->first();

        return view(
            'mip.curah-hujan',
            compact(
                'location_id',
                'location_name',
                'monitoring_type',
                'monitoring_id',
                'data_limbah'   // kirim data lama ke view
            )
        );
    }


    public function store_curah(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|integer|exists:locations,location_id',
            'monitoring_id' => 'required|integer',
            'CH' => 'nullable|numeric',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
        ]);

        // Cek pengisian form
        $CH = $request->input('CH');
        $jam_mulai = $request->input('jam_mulai');
        $jam_selesai = $request->input('jam_selesai');

        if ($CH && $jam_mulai && $jam_selesai) {
            $status = 'completed';
        } elseif ($CH || $jam_mulai || $jam_selesai) {
            $status = 'draft';
        } else {
            $status = 'empty';
        }

        CurahHujan::create([
            'location_id' => $request->location_id,
            'monitoring_id' => $request->monitoring_id,
            'CH' => $CH,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
        ]);

        // Update status lokasi
        $location = Location::where('location_id', $request->location_id)->first();
        if ($location) {
            $location->keterangan = $status;
            $location->save();
        }

        return redirect()->route('lokasi-curah')->with('success', 'Data berhasil disimpan.');
    }


    public function edit_curah(Request $request)
    {
        // Pakai method tambah_curah supaya form sama dan data lama bisa dikirim
        return $this->tambah_curah($request);
    }

    public function update_curah(Request $request, $id)
    {
        $validatedData = $request->validate([
            'CH' => 'nullable|numeric',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
        ]);

        $curah = CurahHujan::findOrFail($id);
        $curah->CH = $request->input('CH');
        $curah->jam_mulai = $request->input('jam_mulai');
        $curah->jam_selesai = $request->input('jam_selesai');

        // Tentukan status
        if ($curah->CH && $curah->jam_mulai && $curah->jam_selesai) {
            $status = 'completed';
        } elseif ($curah->CH || $curah->jam_mulai || $curah->jam_selesai) {
            $status = 'draft';
        } else {
            $status = 'empty';  
        }

        $curah->save();

        // Update status lokasi
        $location = Location::where('location_id', $curah->location_id)->first();
        if ($location) {
            $location->keterangan = $status;
            $location->save();
        }

        return redirect()->route('lokasi-curah')->with('success', 'Data berhasil diperbarui.');
    }
}
