<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Kebisingan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KebisinganController extends Controller
{
    public function lokasiKebisingan(Request $request)
    {
        $selectedDate = $request->query('date', now()->toDateString());

        // Ambil lokasi monitoring kebisingan aktif dengan monitoring_id yang benar
        $lokasi_monitoring_kebisingan = Location::with(['monitoringType'])
            ->where('monitoring_id', 22000005) // Gunakan monitoring_id yang benar
            ->where('status', 1)
            ->get();

        // Debug: Log untuk memeriksa data yang diambil
        \Log::info('Lokasi data:', $lokasi_monitoring_kebisingan->toArray());

        // Ambil data kebisingan berdasarkan tanggal yang dipilih
        $dataByDate = Kebisingan::whereDate('created_at', $selectedDate)
            ->get()
            ->groupBy('location_id');

        // Tentukan status per lokasi
        $statusPerLokasi = [];

        foreach ($lokasi_monitoring_kebisingan as $lokasi) {
            $records = $dataByDate->get($lokasi->location_id);

            if (!$records || $records->isEmpty()) {
                $statusPerLokasi[$lokasi->location_id] = 'empty';
                continue;
            }

            $countInput = $records->count();

            // Updated status logic:
            // - empty: 0 data (tidak ada data sama sekali)
            // - draft: 1-119 data (beberapa data, belum lengkap)
            // - completed: 120 data (data lengkap sesuai maksimal)
            if ($countInput == 0) {
                $statusPerLokasi[$lokasi->location_id] = 'empty';
            } elseif ($countInput < 120) {
                $statusPerLokasi[$lokasi->location_id] = 'draft';
            } else {
                $statusPerLokasi[$lokasi->location_id] = 'completed';
            }
        }

        return view('mip.lokasi-kebisingan', compact('lokasi_monitoring_kebisingan', 'selectedDate', 'statusPerLokasi'));
    }

    public function tambah_kebisingan(Request $request)
    {
        $location_id = $request->query('location_id');
        $location_name = $request->query('location_name');
        $monitoring_type = $request->query('monitoring_type');
        $monitoring_id = $request->query('monitoring_id');
        $selectedDate = $request->query('date', now()->toDateString());

        // Jika monitoring_type kosong, ambil dari database
        if (empty($monitoring_type) && $location_id) {
            $location = Location::with('monitoringType')->find($location_id);
            if ($location && $location->monitoringType) {
                $monitoring_type = $location->monitoringType->monitoring_types ?? 'Monitoring Kebisingan';
            }
        }

        // Set default jika masih kosong
        if (empty($monitoring_type)) {
            $monitoring_type = 'Monitoring Kebisingan';
        }

        return view('mip.kebisingan', compact('location_id', 'location_name', 'monitoring_type', 'monitoring_id', 'selectedDate'));
    }

    public function store_kebisingan(Request $request)
    {
        $validatedData = $request->validate([
            'spl' => 'required|array|max:120', // Tambah max validation
            'spl.*' => 'required|numeric|min:0',
            'location_id' => 'required|integer',
            'monitoring_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $date = Carbon::parse($validatedData['date'])->startOfDay();
        
        // Debug: Log tanggal yang akan disimpan
        \Log::info('Storing kebisingan data with date: ' . $date->toDateTimeString());

        DB::beginTransaction();
        try {
            foreach ($validatedData['spl'] as $key => $value) {
                $second = 'L' . $key; // L1, L2, L3, dst.

                // Gunakan DB::table untuk lebih kontrol terhadap timestamps
                DB::table('kebisingan')->insert([
                    'second' => $second,
                    'spl_db' => $value,
                    'location_id' => $validatedData['location_id'],
                    'monitoring_id' => $validatedData['monitoring_id'],
                    'created_at' => $date->toDateTimeString(),
                    'updated_at' => $date->toDateTimeString(),
                ]);
            }

            DB::commit();

            $dataCount = count($validatedData['spl']);
            $statusMessage = $dataCount == 120 ? 'Data Kebisingan lengkap berhasil disimpan (120 data).' : "Data Kebisingan berhasil disimpan ($dataCount dari 120 data).";

            return redirect()->route('lokasi-kebisingan', ['date' => $validatedData['date']])
                ->with('success', $statusMessage);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|integer',
            'date' => 'required|date',
            'spl' => 'required|array|max:120', // Tambah max validation
            'spl.*' => 'required|numeric|min:0',
            'monitoring_id' => 'required|integer',
        ]);

        $location_id = $validatedData['location_id'];
        $date = Carbon::parse($validatedData['date'])->startOfDay();
        $splInputs = $validatedData['spl'];

        DB::beginTransaction();
        try {
            // Hapus data lama untuk lokasi dan tanggal ini
            Kebisingan::where('location_id', $location_id)
                ->whereDate('created_at', $date)
                ->delete();

            // Simpan data baru menggunakan DB::table untuk kontrol timestamps
            foreach ($splInputs as $key => $value) {
                $second = 'L' . $key;

                DB::table('kebisingan')->insert([
                    'location_id' => $location_id,
                    'second' => $second,
                    'spl_db' => $value,
                    'monitoring_id' => $validatedData['monitoring_id'],
                    'created_at' => $date->toDateTimeString(),
                    'updated_at' => $date->toDateTimeString(),
                ]);
            }

            DB::commit();

            $dataCount = count($splInputs);
            $statusMessage = $dataCount == 120 ? 'Data Kebisingan lengkap berhasil diperbarui (120 data).' : "Data Kebisingan berhasil diperbarui ($dataCount dari 120 data).";

            return redirect()->route('lokasi-kebisingan', ['date' => $validatedData['date']])
                ->with('success', $statusMessage);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $location_id = $request->query('location_id');
        $date = $request->query('date');

        if (!$location_id || !$date) {
            return redirect()->route('lokasi-kebisingan')->with('error', 'Parameter tidak lengkap.');
        }

        // Ambil data kebisingan untuk lokasi dan tanggal tertentu
        $data = Kebisingan::where('location_id', $location_id)
            ->whereDate('created_at', $date)
            ->orderBy('second')
            ->get();

        if ($data->isEmpty()) {
            return redirect()->route('lokasi-kebisingan')->with('error', 'Data tidak ditemukan.');
        }

        // Ambil informasi lokasi dengan relasi monitoringType
        $location = Location::with('monitoringType')->find($location_id);

        if (!$location) {
            return redirect()->route('lokasi-kebisingan')->with('error', 'Lokasi tidak ditemukan.');
        }

        // Pastikan monitoring_type diambil dengan benar
        $monitoring_type = 'Monitoring Kebisingan'; // Default value
        if ($location->monitoringType) {
            $monitoring_type = $location->monitoringType->monitoring_types ?? $monitoring_type;
        }

        return view('mip.kebisingan', [
            'data' => $data,
            'location' => $location,
            'date' => $date,
            'location_id' => $location->location_id,
            'location_name' => $location->location_name,
            'monitoring_type' => $monitoring_type,
            'monitoring_id' => $location->monitoring_id,
            'selectedDate' => $date,
        ]);
    }

    public function index()
    {
        // Method untuk halaman index kebisingan jika diperlukan
        return view('mip.kebisingan-index');
    }

    /**
     * Helper method untuk mendapatkan status berdasarkan jumlah data
     */
    public function getStatusByDataCount($count)
    {
        if ($count == 0) {
            return [
                'status' => 'empty',
                'label' => 'Tidak Ada Data',
                'description' => 'Belum ada data yang diinput'
            ];
        } elseif ($count < 120) {
            return [
                'status' => 'draft',
                'label' => 'Draft',
                'description' => "$count dari 120 data telah diinput"
            ];
        } else {
            return [
                'status' => 'completed',
                'label' => 'Lengkap',
                'description' => '120 data telah lengkap'
            ];
        }
    }

    /**
     * Method untuk mendapatkan informasi lokasi dengan monitoring type
     */
    public function getLocationInfo($location_id)
    {
        $location = Location::with('monitoringType')->find($location_id);
        
        if (!$location) {
            return null;
        }

        return [
            'location_id' => $location->location_id,
            'location_name' => $location->location_name,
            'monitoring_id' => $location->monitoring_id,
            'monitoring_type' => $location->monitoringType ? 
                $location->monitoringType->monitoring_types : 'Monitoring Kebisingan',
            'status' => $location->status
        ];
    }
}