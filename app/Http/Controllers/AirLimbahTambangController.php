<?php

namespace App\Http\Controllers;

use App\Models\AirLimbahTambang;
use App\Models\Location;
use Illuminate\Http\Request;

class AirLimbahTambangController extends Controller
{
    // Tampilkan semua lokasi monitoring air limbah
    public function lokasiLimbah()
    {
        $lokasi_monitoring_limbah_tambang = Location::where('monitoring_id', 1)->get();
        return view('mip.lokasi-limbah', compact('lokasi_monitoring_limbah_tambang'));
    }


    // Tampilkan form tambah/edit
    public function tambah_limbah(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');

        $data_limbah = AirLimbahTambang::where('location_id', $location_id)
            ->orderByDesc('created_at')
            ->first();

        return view('mip.limbah-tambang', compact(
            'location_id',
            'location_name',
            'monitoring_type',
            'monitoring_id',
            'data_limbah'
        ));
    }



    // Fungsi untuk menyimpan atau mengupdate data limbah
    public function store_limbah(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'id' => 'nullable|integer|exists:air_limbah_tambang,id',
            'ph_inlet' => 'nullable|numeric',
            'ph_outlet_1' => 'nullable|numeric',
            'ph_outlet_2' => 'nullable|numeric',
            'treatment_kapur' => 'nullable|numeric',
            'treatment_pac' => 'nullable|numeric',
            'treatment_tawas' => 'nullable|numeric',
            'tss_inlet' => 'nullable|numeric',
            'tss_outlet' => 'nullable|numeric',
            'fe_outlet' => 'nullable|numeric',
            'mn_outlet' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'velocity' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
            'location_id' => 'required|integer',
            'monitoring_id' => 'required|integer',
        ]);

        // Jika ID ada, maka lakukan update, jika tidak maka create data baru
        if (!empty($validatedData['id'])) {
            // Update data lama berdasarkan ID
            $limbah = AirLimbahTambang::find($validatedData['id']);
            if ($limbah) {
                $limbah->update($validatedData);
            }
        } else {
            // Simpan data baru jika ID tidak ada
            AirLimbahTambang::create($validatedData);
        }

        // Hitung jumlah field yang terisi (kecuali location_id, monitoring_id, id)
        $fieldCount = collect($validatedData)
            ->except(['location_id', 'monitoring_id', 'id'])
            ->filter(fn($v) => !is_null($v) && $v !== '')
            ->count();

        // Tentukan status keterangan
        $status_keterangan = match (true) {
            $fieldCount === 0 => 'empty',
            $fieldCount < 12 => 'draft',
            default => 'completed',
        };

        // Update kolom 'keterangan' di tabel locations berdasarkan location_id
        $location = Location::find($validatedData['location_id']);
        if ($location) {
            $location->keterangan = $status_keterangan;
            $location->save();
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('lokasi-limbah')->with('success', 'Data limbah berhasil disimpan.');
    }

    // Fungsi untuk mengedit data limbah
    public function edit_limbah(Request $request, $id)
    {
        // Ambil data berdasarkan ID
        $data_limbah = AirLimbahTambang::findOrFail($id);

        // Ambil data lokasi dan monitoring type
        $location_id = $data_limbah->location_id;
        $location_name = $data_limbah->location->location_name; // Asumsi ada relasi 'location'
        $monitoring_type = $data_limbah->monitoringType->monitoring_types; // Asumsi ada relasi 'monitoringType'
        $monitoring_id = $data_limbah->monitoring_id; // Ambil monitoring_id dari data limbah

        // Kirim data ke view
        return view('mip.limbah-tambang', compact('data_limbah', 'location_id', 'location_name', 'monitoring_type', 'monitoring_id'));
    }



    // Fungsi untuk memperbarui data limbah
    public function update_limbah(Request $request, $id)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'ph_inlet' => 'nullable|numeric',
            'ph_outlet_1' => 'nullable|numeric',
            'ph_outlet_2' => 'nullable|numeric',
            'treatment_kapur' => 'nullable|numeric',
            'treatment_pac' => 'nullable|numeric',
            'treatment_tawas' => 'nullable|numeric',
            'tss_inlet' => 'nullable|numeric',
            'tss_outlet' => 'nullable|numeric',
            'fe_outlet' => 'nullable|numeric',
            'mn_outlet' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'velocity' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Temukan data berdasarkan ID
        $limbah = AirLimbahTambang::findOrFail($id);
        $limbah->update($validatedData);

        // Hitung jumlah field yang terisi untuk menentukan status
        $fieldCount = collect($validatedData)
            ->filter(fn($v) => !is_null($v) && $v !== '')
            ->count();

        $status_keterangan = match (true) {
            $fieldCount === 0 => 'empty',
            $fieldCount < 12 => 'draft',
            default => 'completed',
        };

        // Update status keterangan di lokasi
        $location = Location::find($limbah->location_id);
        if ($location) {
            $location->keterangan = $status_keterangan;
            $location->save();
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('lokasi-limbah')->with('success', 'Data limbah berhasil diperbarui.');
    }
}
