<?php

namespace App\Http\Controllers;

use App\Models\AirLimbahTambang;
use Illuminate\Support\Facades\DB;

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
    public function edit_limbah(Request $request, $location_id)
    {
        // Cari data limbah terbaru berdasarkan location_id
        $data_limbah = AirLimbahTambang::where('location_id', $location_id)
            ->orderByDesc('created_at')
            ->first();

        if (!$data_limbah) {
            // Jika belum ada data limbah untuk lokasi ini, redirect ke form tambah data
            return redirect()->route('tambah.limbah', [
                'location_id' => $location_id,
                // Ambil nama lokasi dan monitoring type untuk query string jika perlu
                'location_name' => Location::where('location_id', $location_id)->value('location_name'),
                'monitoring_type' => Location::where('location_id', $location_id)->with('monitoringType')->first()->monitoringType->monitoring_types ?? '',
                'monitoring_id' => Location::where('location_id', $location_id)->value('monitoring_id'),
            ])->with('info', 'Data limbah belum ada, silakan tambah data.');
        }

        // Ambil data lokasi
        $location = Location::find($location_id);
        if (!$location) {
            abort(404, 'Lokasi tidak ditemukan');
        }

        // Ambil monitoring type
        $monitoringType = $location->monitoringType;
        if (!$monitoringType) {
            abort(404, 'Monitoring type tidak ditemukan');
        }

        // Siapkan data untuk view
        $location_name = $location->location_name;
        $monitoring_type = $monitoringType->monitoring_types;
        $monitoring_id = $location->monitoring_id;

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
