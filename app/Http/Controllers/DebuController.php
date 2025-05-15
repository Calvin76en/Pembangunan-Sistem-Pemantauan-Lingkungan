<?php

namespace App\Http\Controllers;

use App\Models\Debu;
use App\Models\Location;
use Illuminate\Http\Request;

class DebuController extends Controller
{
    public function lokasiDebu()
    {
        $monitoring_id = 4;

        $lokasi_monitoring_debu = Location::where('monitoring_id', $monitoring_id)
            ->with('monitoringType')
            ->get();

        foreach ($lokasi_monitoring_debu as $lokasi) {
            $debuLengkap = Debu::where('location_id', $lokasi->location_id)
                ->where('monitoring_id', $monitoring_id)
                ->whereNotNull('waktu')->where('waktu', '!=', '')
                ->whereNotNull('status_debu')->where('status_debu', '!=', '')
                ->get();

            $jumlahDiisi = $debuLengkap->pluck('waktu')->unique()->count();

            if ($jumlahDiisi >= 2) {
                $lokasi->keterangan = 'completed';
            } elseif ($jumlahDiisi > 0) {
                $lokasi->keterangan = 'draft';
            } else {
                $lokasi->keterangan = 'empty';
            }
        }

        return view('mip.lokasi-debu', compact('lokasi_monitoring_debu'));
    }

    public function tambah_debu(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');

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

    public function store_debu(Request $request)
    {
        $validatedData = $request->validate([
            'waktu' => 'nullable|string',
            'status_debu' => 'nullable|string',
            'location_id' => 'required|integer|exists:locations,location_id',
            'monitoring_id' => 'required|integer',
        ]);

        // Validasi minimal salah satu diisi
        if (empty($validatedData['waktu']) && empty($validatedData['status_debu'])) {
            return back()->withErrors(['waktu' => 'Minimal isi Waktu atau Status Debu'])->withInput();
        }

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

        $this->updateLokasiStatus($validatedData['location_id'], $validatedData['monitoring_id']);

        return redirect()->route('lokasi-debu')->with('success', $message);
    }

    private function updateLokasiStatus($location_id, $monitoring_id)
    {
        $debuLengkap = Debu::where('location_id', $location_id)
            ->where('monitoring_id', $monitoring_id)
            ->whereNotNull('waktu')->where('waktu', '!=', '')
            ->whereNotNull('status_debu')->where('status_debu', '!=', '')
            ->get();

        $jumlahDiisi = $debuLengkap->pluck('waktu')->unique()->count();

        $lokasi = Location::find($location_id);
        if (!$lokasi) return;

        if ($jumlahDiisi >= 2) {
            $lokasi->keterangan = 'completed';
        } elseif ($jumlahDiisi > 0) {
            $lokasi->keterangan = 'draft';
        } else {
            $lokasi->keterangan = 'empty';
        }
        $lokasi->save();
    }

    public function update_debu(Request $request, $id)
    {
        $validatedData = $request->validate([
            'waktu' => 'nullable|string',
            'status_debu' => 'nullable|string',
        ]);

        if (empty($validatedData['waktu']) && empty($validatedData['status_debu'])) {
            return back()->withErrors(['waktu' => 'Minimal isi Waktu atau Status Debu'])->withInput();
        }

        $debu = Debu::findOrFail($id);
        $debu->waktu = $validatedData['waktu'];
        $debu->status_debu = $validatedData['status_debu'];
        $debu->save();

        $this->updateLokasiStatus($debu->location_id, $debu->monitoring_id);

        return redirect()->route('lokasi-debu')->with('success', 'Data berhasil diperbarui.');
    }
}
