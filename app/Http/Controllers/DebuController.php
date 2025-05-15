<?php

namespace App\Http\Controllers;

use App\Models\Debu;
use App\Models\Location;
use Illuminate\Http\Request;

class DebuController extends Controller
{
    // Halaman daftar lokasi pemantauan debu
    public function lokasiDebu()
    {
        $monitoring_id = 4; // monitoring_id untuk debu

        // Ambil semua lokasi dengan monitoring_id = 4
        $lokasi_monitoring_debu = Location::where('monitoring_id', $monitoring_id)->get();

        foreach ($lokasi_monitoring_debu as $lokasi) {
            // Ambil data debu untuk lokasi tsb, filter hanya waktu & status yang valid (tidak null dan tidak kosong)
            $debuLengkap = \App\Models\Debu::where('location_id', $lokasi->location_id)
                ->where('monitoring_id', $monitoring_id)
                ->whereNotNull('waktu')
                ->whereNotNull('status_debu')
                ->where('waktu', '!=', '')
                ->where('status_debu', '!=', '')
                ->get();

            // Hitung jumlah waktu unik yang sudah diisi (misal Pagi, Siang, Sore)
            $jumlahDiisi = $debuLengkap->pluck('waktu')->unique()->count();

            // Tentukan status berdasarkan jumlah data yang sudah diisi
            if ($jumlahDiisi === 3) {
                $lokasi->keterangan = 'completed'; // semua waktu sudah diisi
            } elseif ($jumlahDiisi > 0) {
                $lokasi->keterangan = 'draft';     // sebagian waktu sudah diisi
            } else {
                $lokasi->keterangan = 'empty';     // belum ada data sama sekali
            }
        }

        return view('mip.lokasi-debu', compact('lokasi_monitoring_debu'));
    }




    // Tampilkan form tambah/edit debu
    public function tambah_debu(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');

        // Ambil data terakhir jika ada
        $data_debu = Debu::where('location_id', $location_id)
            ->where('monitoring_id', $monitoring_id)
            ->latest()
            ->first();

        return view('mip.debu', compact(
            'location_id',
            'location_name',
            'monitoring_type',
            'monitoring_id',
            'data_debu'
        ));
    }

    // Simpan atau update data debu
    public function store_debu(Request $request)
    {
        $validatedData = $request->validate([
            'waktu' => 'required|string',
            'status_debu' => 'nullable|string', // boleh kosong / tidak wajib
            'location_id' => 'required|integer',
            'monitoring_id' => 'required|integer',
        ]);

        // Cek data existing berdasarkan waktu, lokasi, monitoring
        $existingData = Debu::where('location_id', $validatedData['location_id'])
            ->where('monitoring_id', $validatedData['monitoring_id'])
            ->where('waktu', $validatedData['waktu'])
            ->first();

        if ($existingData) {
            $existingData->update($validatedData);
            $message = 'Data berhasil diperbarui.';
        } else {
            Debu::create($validatedData);
            $message = 'Data berhasil disimpan.';
        }

        return redirect()->route('lokasi-debu', [
            'location_id' => $validatedData['location_id'],
            'monitoring_id' => $validatedData['monitoring_id'],
        ])->with('success', $message);
    }
}
