<?php

namespace App\Http\Controllers;

use App\Models\Debu;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DebuController extends Controller
{
    public function lokasiDebu(Request $request)
    {
        $selectedDate = $request->query('date', now()->toDateString());
        $monitoring_id = 22000004;

        // Ambil data lokasi berdasarkan monitoring_id dan status aktif
        $lokasi_monitoring_debu = Location::where('monitoring_id', $monitoring_id)
            ->with('monitoringType')
            ->where('status', 1)
            ->get();

        // Buat array untuk menyimpan status per lokasi
        $statusPerLokasi = [];

        foreach ($lokasi_monitoring_debu as $lokasi) {
            // Ambil SEMUA data debu untuk lokasi dan tanggal yang dipilih (tanpa filter field kosong)
            $allDataForDate = Debu::where('location_id', $lokasi->location_id)
                ->where('monitoring_id', $monitoring_id)
                ->whereRaw('DATE(created_at) = ?', [$selectedDate])
                ->get();

            if ($allDataForDate->isEmpty()) {
                // Tidak ada data sama sekali
                $statusPerLokasi[$lokasi->location_id] = 'empty';
                continue;
            }

            // Hitung data yang lengkap (kedua field terisi)
            $debuLengkap = $allDataForDate->filter(function($data) {
                return !empty($data->waktu) && !empty($data->status_debu);
            });

            $jumlahLengkap = $debuLengkap->pluck('waktu')->unique()->count();

            // Tentukan status berdasarkan kelengkapan data
            if ($jumlahLengkap >= 2) {
                $statusPerLokasi[$lokasi->location_id] = 'completed';
            } elseif ($jumlahLengkap > 0 || $allDataForDate->count() > 0) {
                // Ada data (lengkap atau tidak lengkap)
                $statusPerLokasi[$lokasi->location_id] = 'draft';
            } else {
                $statusPerLokasi[$lokasi->location_id] = 'empty';
            }
        }

        // Kirim data ke view
        return view('mip.lokasi-debu', compact('lokasi_monitoring_debu', 'selectedDate', 'statusPerLokasi'));
    }

    public function tambah_debu(Request $request)
    {
        // Ambil parameter dari query string dengan validasi
        $selectedDate = $request->query('date', now()->toDateString());
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');

        // Validasi date format
        if (!$selectedDate || !Carbon::canBeCreatedFromFormat($selectedDate, 'Y-m-d')) {
            $selectedDate = now()->toDateString();
        }

        // Validasi required parameters
        if (!$location_id || !$monitoring_id) {
            return redirect()->route('mip-lokasi-debu')
                ->with('error', 'Parameter lokasi tidak valid');
        }

        // Debugging: Pastikan tanggal yang diterima benar
        \Log::info('=== TAMBAH DEBU DEBUG START ===');
        \Log::info('Selected Date in tambah_debu: ' . $selectedDate);
        \Log::info('Location ID: ' . $location_id);
        \Log::info('Monitoring ID: ' . $monitoring_id);
        \Log::info('Query Parameters: ', $request->all());

        // Debug: Cek semua data untuk location dan monitoring_id ini
        $allDataForLocation = Debu::where('location_id', $location_id)
            ->where('monitoring_id', $monitoring_id)
            ->get(['id', 'waktu', 'status_debu', 'created_at']);
            
        \Log::info('All data for location ' . $location_id . ':');
        foreach($allDataForLocation as $data) {
            \Log::info('- ID: ' . $data->id . ', Date: ' . Carbon::parse($data->created_at)->toDateString() . ', Waktu: ' . ($data->waktu ?? 'NULL') . ', Status: ' . ($data->status_debu ?? 'NULL'));
        }

        // PERBAIKAN: Cari SEMUA data untuk tanggal yang dipilih (tanpa filter field kosong)
        // untuk menentukan apakah form dalam mode EDIT atau ADD
        $allDataForSelectedDate = Debu::where('location_id', $location_id)
            ->where('monitoring_id', $monitoring_id)
            ->whereRaw('DATE(created_at) = ?', [$selectedDate])
            ->get();

        \Log::info('All data for selected date ' . $selectedDate . ': ' . $allDataForSelectedDate->count() . ' records');

        $data_debu = null;

        if ($allDataForSelectedDate->isNotEmpty()) {
            // Ada data untuk tanggal ini - MODE EDIT
            // Ambil data pertama yang ditemukan (bisa yang lengkap atau tidak lengkap)
            $data_debu = $allDataForSelectedDate->first();
            
            \Log::info('EDIT MODE - Found existing data:');
            \Log::info('- ID: ' . $data_debu->id);
            \Log::info('- Created: ' . $data_debu->created_at);
            \Log::info('- Waktu: ' . ($data_debu->waktu ?? 'NULL'));
            \Log::info('- Status: ' . ($data_debu->status_debu ?? 'NULL'));
        } else {
            // Tidak ada data untuk tanggal ini - MODE ADD
            $data_debu = null;
            \Log::info('ADD MODE - No data found for selected date');
        }

        \Log::info('=== TAMBAH DEBU DEBUG END ===');

        // Kirim data ke view
        return view('mip.debu', compact(
            'location_id',
            'location_name',
            'monitoring_type',
            'monitoring_id',
            'data_debu',
            'selectedDate'
        ));
    }

    public function store_debu(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'waktu' => 'nullable|string|in:Pagi,Siang,Sore',
            'status_debu' => 'nullable|string|in:ST,T,M,SM',
            'location_id' => 'required|integer|exists:locations,location_id',
            'monitoring_id' => 'required|integer',
            'selectedDate' => 'required|date',
        ]);

        // Ambil nilai dari form
        $waktu = $validatedData['waktu'] ?? null;
        $statusDebu = $validatedData['status_debu'] ?? null;

        // Cek apakah minimal satu field harus diisi
        if (empty($waktu) && empty($statusDebu)) {
            return back()->withErrors(['waktu' => 'Minimal isi salah satu: Waktu atau Status Debu'])->withInput();
        }

        \Log::info('=== STORE DEBU DEBUG ===');
        \Log::info('Storing data for date: ' . $validatedData['selectedDate']);
        \Log::info('Location ID: ' . $validatedData['location_id']);
        \Log::info('Waktu: ' . ($waktu ?? 'NULL'));
        \Log::info('Status Debu: ' . ($statusDebu ?? 'NULL'));

        // Cek apakah sudah ada data untuk tanggal ini
        $existingDataAny = Debu::where('location_id', $validatedData['location_id'])
            ->where('monitoring_id', $validatedData['monitoring_id'])
            ->whereRaw('DATE(created_at) = ?', [$validatedData['selectedDate']])
            ->first();

        if ($existingDataAny) {
            // UPDATE data yang sudah ada
            $existingDataAny->update([
                'waktu' => $waktu ?? $existingDataAny->waktu,
                'status_debu' => $statusDebu ?? $existingDataAny->status_debu,
                'updated_at' => now(),
            ]);
            $message = 'Data berhasil diperbarui.';
            \Log::info('Updated existing data with ID: ' . $existingDataAny->id);
        } else {
            // CREATE data baru
            $debu = new Debu();
            $debu->waktu = $waktu;
            $debu->status_debu = $statusDebu;
            $debu->location_id = $validatedData['location_id'];
            $debu->monitoring_id = $validatedData['monitoring_id'];
            $debu->created_at = $validatedData['selectedDate'] . ' ' . now()->format('H:i:s');
            $debu->updated_at = now();
            $debu->save();

            $message = 'Data berhasil disimpan.';
            \Log::info('Created new data with ID: ' . $debu->id);
        }

        return redirect()->route('mip-lokasi-debu', ['date' => $validatedData['selectedDate']])
            ->with('success', $message);
    }

    public function update_debu(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'waktu' => 'nullable|string|in:Pagi,Siang,Sore',
            'status_debu' => 'nullable|string|in:ST,T,M,SM',
            'selectedDate' => 'required|date',
        ]);

        // Ambil nilai dari form
        $waktu = $validatedData['waktu'] ?? null;
        $statusDebu = $validatedData['status_debu'] ?? null;

        // Cek apakah minimal salah satu field harus diisi
        if (empty($waktu) && empty($statusDebu)) {
            return back()->withErrors(['waktu' => 'Minimal isi salah satu: Waktu atau Status Debu'])->withInput();
        }

        $debu = Debu::findOrFail($id);

        \Log::info('=== UPDATE DEBU DEBUG ===');
        \Log::info('Updating data ID: ' . $id);
        \Log::info('Selected Date: ' . $validatedData['selectedDate']);
        \Log::info('New Waktu: ' . ($waktu ?? 'NULL'));
        \Log::info('New Status Debu: ' . ($statusDebu ?? 'NULL'));
        \Log::info('Current data - Waktu: ' . ($debu->waktu ?? 'NULL') . ', Status: ' . ($debu->status_debu ?? 'NULL') . ', Created: ' . $debu->created_at);

        // Jika waktu diubah dan tidak null, cek apakah data duplikat sudah ada
        if (!empty($waktu) && $waktu !== $debu->waktu) {
            $existingData = Debu::where('location_id', $debu->location_id)
                ->where('monitoring_id', $debu->monitoring_id)
                ->where('waktu', $waktu)
                ->whereRaw('DATE(created_at) = ?', [$validatedData['selectedDate']])
                ->where('id', '!=', $id)
                ->first();

            if ($existingData) {
                \Log::info('Duplicate waktu found, rejecting update');
                return back()->withErrors(['waktu' => 'Data untuk waktu ' . $waktu . ' sudah ada di tanggal ini.'])->withInput();
            }
        }

        // Update data
        $debu->update([
            'waktu' => $waktu ?? $debu->waktu,
            'status_debu' => $statusDebu ?? $debu->status_debu,
            'updated_at' => now(),
        ]);

        \Log::info('Data successfully updated');

        return redirect()->route('mip-lokasi-debu', ['date' => $validatedData['selectedDate']])
            ->with('success', 'Data berhasil diperbarui.');
    }
}