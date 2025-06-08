<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Location;
use App\Models\CurahHujan;
use Illuminate\Http\Request;
use App\Models\OilTrapFuelTrap;
use App\Models\AirLimbahTambang;
use Illuminate\Support\Facades\DB;

class PemantauanController extends Controller
{
    /**
     * Menampilkan halaman Curah Hujan (tanpa filter tanggal).
     */
    public function curahHujan()
    {
        return view('mip.curah-hujan');
    }

    /**
     * Menampilkan halaman Debu (tanpa filter tanggal).
     */
    public function debu()
    {
        return view('mip.debu');
    }

    /**
     * Menampilkan halaman Kebisingan (tanpa filter tanggal).
     */
    public function kebisingan()
    {
        return view('mip.kebisingan');
    }

    /**
     * Menampilkan halaman Oil & Fuel Trap (tanpa filter tanggal).
     */
    public function oilfuelTrap()
    {
        return view('mip.oilfuel-trap');
    }

    /**
     * Menampilkan daftar lokasi untuk monitoring Curah Hujan.
     */
    public function lokasiCurah(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Ambil semua lokasi monitoring curah hujan yang aktif
        $lokasi_monitoring_curah_hujan = Location::with('monitoringType')
            ->where('monitoring_id', 22000003) // Curah Hujan
            ->where('status', 1) // Status aktif
            ->get();

        // Ambil data curah hujan pada tanggal yang dipilih, kelompokkan berdasarkan location_id
        $dataByDate = CurahHujan::whereDate('created_at', $selectedDate)
            ->get()
            ->groupBy('location_id'); // Mengelompokkan berdasarkan location_id

        // Array untuk menyimpan status keterangan per lokasi
        $statusPerLokasi = [];

        // Menentukan status setiap lokasi berdasarkan data yang ada
        foreach ($lokasi_monitoring_curah_hujan as $location) {
            $records = $dataByDate->get($location->location_id);

            if (!$records || $records->isEmpty()) {
                $statusPerLokasi[$location->location_id] = 'empty';
                continue;
            }

            $requiredFields = ['CH', 'jam_mulai', 'jam_selesai'];

            $allComplete = true;
            $anyFilled = false;

            foreach ($records as $record) {
                $recordComplete = true;
                $recordHasData = false;

                foreach ($requiredFields as $field) {
                    if (is_null($record->$field) || $record->$field === '') {
                        $recordComplete = false;
                    } else {
                        $recordHasData = true;
                        $anyFilled = true;
                    }
                }

                if (!$recordComplete) {
                    $allComplete = false;
                }
            }

            if ($allComplete && $anyFilled) {
                $statusPerLokasi[$location->location_id] = 'completed';
            } elseif ($anyFilled) {
                $statusPerLokasi[$location->location_id] = 'draft';
            } else {
                $statusPerLokasi[$location->location_id] = 'empty';
            }
        }

        // Kirim data ke view
        return view('mip.lokasi-curah', [
            'lokasi_monitoring_curah_hujan' => $lokasi_monitoring_curah_hujan, // Perbaiki di sini
            'dataByDate' => $dataByDate,
            'selectedDate' => $selectedDate,
            'statusPerLokasi' => $statusPerLokasi,
        ]);
    }





    /**
     * Menampilkan daftar lokasi untuk monitoring Debu.
     */
    public function lokasiDebu(Request $request)
    {
        $selectedDate = $request->query('date', now()->toDateString());

        // Ambil lokasi monitoring debu yang aktif (monitoring_id = 22000004)
        $lokasi_monitoring_debu = Location::with('monitoringType')
            ->where('monitoring_id', 22000004)
            ->where('status', 1)
            ->get();

        // Gunakan created_at untuk filter tanggal
        $dataByDate = DB::table('debu')
            ->whereDate('created_at', $selectedDate)
            ->get()
            ->groupBy('location_id');

        // Logic status berdasarkan data yang ada
        $statusPerLokasi = [];

        foreach ($lokasi_monitoring_debu as $lokasi) {
            // Ambil records untuk lokasi ini
            $records = $dataByDate->get($lokasi->location_id);

            // 1. Jika tidak ada data sama sekali
            if (!$records || $records->isEmpty()) {
                $statusPerLokasi[$lokasi->location_id] = 'empty';
                continue;
            }

            // 2. Karena tabel debu hanya punya 2 field input (waktu & status_debu),
            //    cek apakah kedua field tersebut terisi
            $allFieldsFilled = true;

            foreach ($records as $record) {
                // Cek apakah kedua field terisi
                if (empty($record->waktu) || empty($record->status_debu)) {
                    $allFieldsFilled = false;
                    break;
                }
            }

            // 3. Tentukan status
            if ($allFieldsFilled) {
                // Kedua field (waktu & status_debu) terisi semua
                $statusPerLokasi[$lokasi->location_id] = 'completed';
            } else {
                // Ada field yang kosong
                $statusPerLokasi[$lokasi->location_id] = 'draft';
            }
        }

        return view('mip.lokasi-debu', compact('lokasi_monitoring_debu', 'selectedDate', 'statusPerLokasi'));
    }



    /**
     * Menampilkan daftar lokasi untuk monitoring Kebisingan.
     */
    public function lokasiKebisingan(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Menggunakan monitoring_id yang benar: 22000005
        $lokasi_monitoring_kebisingan = Location::with('monitoringType')
            ->where('monitoring_id', 22000005) // ID yang benar untuk kebisingan
            ->where('status', 1)
            ->get();

        // Debug: Log jumlah lokasi yang ditemukan
        \Log::info('Lokasi kebisingan found: ' . $lokasi_monitoring_kebisingan->count());

        // Ambil data kebisingan yang dibuat pada tanggal terpilih dari tabel kebisingan
        $dataByDate = DB::table('kebisingan')
            ->whereDate('created_at', $selectedDate)
            ->get()
            ->groupBy('location_id');

        $statusPerLokasi = [];

        foreach ($lokasi_monitoring_kebisingan as $lokasi) {
            $records = $dataByDate->get($lokasi->location_id);

            if (!$records || $records->isEmpty()) {
                // Tidak ada data sama sekali di tanggal itu untuk lokasi ini
                $statusPerLokasi[$lokasi->location_id] = 'empty';
                continue;
            }

            // Hitung jumlah input berdasarkan unique second values
            $countInput = $records->count();

            if ($countInput == 0) {
                // Jika tidak ada input
                $statusPerLokasi[$lokasi->location_id] = 'empty';
            } elseif ($countInput < 3) {
                // Jika kurang dari 3 inputan, status draft
                $statusPerLokasi[$lokasi->location_id] = 'draft';
            } else {
                // Jika sudah 3 atau lebih inputan, status completed
                $statusPerLokasi[$lokasi->location_id] = 'completed';
            }
        }

        return view('mip.lokasi-kebisingan', [
            'lokasi_monitoring_kebisingan' => $lokasi_monitoring_kebisingan,
            'selectedDate' => $selectedDate,
            'statusPerLokasi' => $statusPerLokasi,
        ]);
    }


    /**
     * Menampilkan halaman Lokasi Air Limbah Tambang dengan filter tanggal via `created_at`.
     */
    public function lokasiLimbah(Request $request)
    {
        // Ambil tanggal yang dipilih dari query string
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Debug: Tampilkan tanggal yang digunakan
        // dd("Selected Date: " . $selectedDate);

        // Ambil semua lokasi yang memiliki monitoring_id = 22000001
        $lokasi = Location::with('monitoringType')
            ->where('monitoring_id', 22000001)
            ->where('status', 1)
            ->get();

        // Debug: Tampilkan lokasi yang ditemukan
        // dd("Lokasi Count: " . $lokasi->count(), $lokasi->pluck('location_id', 'location_name'));

        // Ambil data air limbah pada tanggal yang dipilih
        $dataByDate = AirLimbahTambang::whereDate('created_at', $selectedDate)
            ->get()
            ->groupBy('location_id');

        // Debug: Tampilkan data yang ditemukan
        // dd("Data Count: " . $dataByDate->count(), $dataByDate->keys());

        $statusPerLokasi = [];

        // Field yang wajib diisi untuk menentukan status completed
        $requiredFields = [
            'ph_inlet',
            'ph_outlet_1',
            'ph_outlet_2',
            'treatment_kapur',
            'treatment_pac',
            'treatment_tawas',
            'tss_inlet',
            'tss_outlet',
            'fe_outlet',
            'mn_outlet',
            'debit',
            'velocity'
        ];

        foreach ($lokasi as $location) {
            $records = $dataByDate->get($location->location_id);

            if (!$records || $records->isEmpty()) {
                $statusPerLokasi[$location->location_id] = 'empty';
                continue;
            }

            $allComplete = true;
            $anyFilled = false;

            foreach ($records as $record) {
                $recordComplete = true;
                $recordHasData = false;

                foreach ($requiredFields as $field) {
                    if (is_null($record->$field) || $record->$field === '') {
                        $recordComplete = false;
                    } else {
                        $recordHasData = true;
                        $anyFilled = true;
                    }
                }

                if (!$recordComplete) {
                    $allComplete = false;
                }
            }

            // Tentukan status
            if ($allComplete && $anyFilled) {
                $statusPerLokasi[$location->location_id] = 'completed';
            } elseif ($anyFilled) {
                $statusPerLokasi[$location->location_id] = 'draft';
            } else {
                $statusPerLokasi[$location->location_id] = 'empty';
            }
        }

        // Debug final: Tampilkan hasil akhir
        // dd("Final Status:", $statusPerLokasi, "DataByDate Keys:", $dataByDate->keys()->toArray());

        return view('mip.lokasi-limbah', [
            'lokasi' => $lokasi,
            'dataByDate' => $dataByDate,
            'selectedDate' => $selectedDate,
            'statusPerLokasi' => $statusPerLokasi,
        ]);
    }


    /**
     * Menampilkan daftar lokasi untuk monitoring Oil & Fuel Trap.
     */
    public function lokasiOilFuel(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Ambil data monitoring Oil & Fuel Trap pada tanggal itu, groupBy location_id
        $dataByDate = OilTrapFuelTrap::whereDate('created_at', $selectedDate)
            ->get()
            ->groupBy('location_id'); // Mengelompokkan berdasarkan location_id

        // Array untuk menyimpan status keterangan per lokasi
        $statusPerLokasi = [];

        // Ambil lokasi monitoring Oil & Fuel Trap yang aktif
        $lokasi_monitoring_oilfuel = Location::with('monitoringType')
            ->where('monitoring_id', 22000002) // Oil Trap & Fuel Trap
            ->where('status', 1) // Status aktif
            ->get();

        // Tentukan status setiap lokasi berdasarkan data yang ada di tabel oil_trap_fuel_trap
        foreach ($lokasi_monitoring_oilfuel as $location) {
            // Ambil data untuk lokasi dan tanggal yang dipilih
            $records = $dataByDate->get($location->location_id);

            if (!$records || $records->isEmpty()) {
                // Jika tidak ada data sama sekali untuk lokasi & tanggal tersebut
                $statusPerLokasi[$location->location_id] = 'empty';
            } else {
                // Jika ada data di tabel oil_trap_fuel_trap untuk lokasi & tanggal ini
                $statusPerLokasi[$location->location_id] = 'completed';
            }
        }

        // Kirim data ke view
        return view('mip.lokasi-oilfuel', [
            'lokasi_monitoring_oilfuel' => $lokasi_monitoring_oilfuel,
            'dataByDate' => $dataByDate,
            'selectedDate' => $selectedDate,
            'statusPerLokasi' => $statusPerLokasi, // Kirim status ke view
        ]);
    }
}
