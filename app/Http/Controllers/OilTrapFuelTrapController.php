<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\OilTrapFuelTrap;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OilTrapFuelTrapController extends Controller
{
    /**
     * Menampilkan halaman lokasi Oil & Fuel Trap dengan filter tanggal.
     */
    public function lokasiOilFuel(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Ambil data monitoring Oil & Fuel Trap pada tanggal itu, keyBy location_id
        $dataByDate = OilTrapFuelTrap::whereDate('created_at', $selectedDate)
            ->get()
            ->keyBy('location_id');

        // Ambil location_ids yang ada data pada tanggal itu
        $locationIdsWithData = $dataByDate->keys()->toArray();

        // Ambil lokasi monitoring Oil & Fuel Trap (monitoring_id=2) yang aktif dan punya data
        $lokasiWithData = Location::with('monitoringType')
            ->where('monitoring_id', 2)
            ->where('status', 1)
            ->whereIn('location_id', $locationIdsWithData)
            ->get();

        // Ambil lokasi monitoring Oil & Fuel Trap yang tidak punya data pada tanggal itu
        $lokasiWithoutData = Location::with('monitoringType')
            ->where('monitoring_id', 2)
            ->where('status', 1)
            ->whereNotIn('location_id', $locationIdsWithData)
            ->get();

        // Gabungkan lokasi yang ada data dan yang tidak ada data agar lengkap tampil
        $allLocations = $lokasiWithData->concat($lokasiWithoutData);

        return view('mip.lokasi-oilfuel', [
            'lokasi_monitoring_oilfuel' => $allLocations,
            'dataByDate' => $dataByDate,
            'selectedDate' => $selectedDate,
        ]);
    }

    /**
     * Menampilkan form tambah/edit data Oil & Fuel Trap.
     */
    public function tambah_oilfuel(Request $request)
    {
        $location_id = $request->query('location_id');
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        if (!$location_id) {
            abort(404, 'Location ID tidak ditemukan');
        }

        $location = Location::with('monitoringType')->find($location_id);
        if (!$location) {
            abort(404, 'Lokasi tidak ditemukan');
        }

        // Cek apakah sudah ada data OilFuel pada tanggal dan lokasi ini
        $existingData = OilTrapFuelTrap::where('location_id', $location_id)
            ->whereDate('created_at', $selectedDate)
            ->first();

        // Jika ada old input (dari redirect withInput), gunakan itu untuk existingData
        if (old('ph')) {
            $existingData = (object) [
                'ph' => old('ph')
            ];
        }

        return view('mip.oilfuel-trap', [
            'location_id' => $location->location_id,
            'location_name' => $location->location_name,
            'monitoring_type' => $location->monitoringType->monitoring_types ?? '',
            'monitoring_id' => $location->monitoring_id,
            'selectedDate' => $selectedDate,
            'existingData' => $existingData,
        ]);
    }

    /**
     * Menyimpan data Oil & Fuel Trap (baru atau update).
     */
    public function store_oilfuel(Request $request)
    {
        try {
            // Validasi dengan rentang pH 6-9
            $validatedData = $request->validate([
                'ph' => [
                    'required',
                    'numeric',
                    'min:6',
                    'max:9',
                    'regex:/^\d+(\.\d{1,2})?$/' // Maksimal 2 desimal
                ],
                'location_id' => 'required|integer',
                'monitoring_id' => 'required|integer',
            ], [
                'ph.required' => 'Nilai pH wajib diisi.',
                'ph.numeric' => 'Nilai pH harus berupa angka.',
                'ph.min' => 'Nilai pH tidak boleh kurang dari 6.0',
                'ph.max' => 'Nilai pH tidak boleh lebih dari 9.0',
                'ph.regex' => 'Nilai pH maksimal 2 angka desimal.',
            ]);

            $selectedDate = $request->input('date', Carbon::now()->toDateString());

            // Cek data yang sudah ada
            $existingData = OilTrapFuelTrap::where('location_id', $validatedData['location_id'])
                ->whereDate('created_at', $selectedDate)
                ->first();

            if ($existingData) {
                $existingData->update($validatedData);
                // Optional: set created_at manual agar sesuai tanggal selectedDate (jika dibutuhkan)
                $existingData->created_at = Carbon::parse($selectedDate);
                $existingData->save();
                $message = 'Data pH berhasil diperbarui!';
            } else {
                // Buat data baru dan set created_at manual agar sesuai selectedDate
                $newData = new OilTrapFuelTrap($validatedData);
                $newData->created_at = Carbon::parse($selectedDate);
                $newData->save();
                $message = 'Data pH berhasil disimpan!';
            }

            // Hitung jumlah field yang terisi (kecuali id, location_id, monitoring_id)
            $fieldCount = collect($validatedData)
                ->except(['location_id', 'monitoring_id'])
                ->filter(fn($v) => !is_null($v) && $v !== '')
                ->count();

            // Tentukan status keterangan lokasi berdasarkan data
            $status_keterangan = match (true) {
                $fieldCount === 0 => 'empty',
                $fieldCount < 1 => 'draft', // karena cuma ada 1 field (ph), jadi draft kalau kosong? bisa disesuaikan
                default => 'completed',
            };

            // Update status keterangan di view, tanpa perlu update tabel locations
            // (Hapus bagian update keterangan pada tabel locations)

            // Redirect ke halaman lokasi dengan pesan sukses
            return redirect()->route('lokasi-oilfuel', ['date' => $selectedDate])
                ->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap error validasi dan kirim kembali dengan pesan error
            $errors = $e->validator->errors();
            $errorMessage = $errors->first('ph');
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }


    /**
     * Menampilkan form edit data Oil & Fuel Trap.
     */
    public function edit_oilfuel(Request $request)
    {
        $location_id = $request->query('location_id');
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        if (!$location_id) {
            abort(404, 'Location ID tidak ditemukan');
        }

        $location = Location::with('monitoringType')->find($location_id);
        if (!$location) {
            abort(404, 'Lokasi tidak ditemukan');
        }

        $existingData = OilTrapFuelTrap::where('location_id', $location_id)
            ->whereDate('created_at', $selectedDate)
            ->first();

        return view('mip.oilfuel-trap', [
            'location_id' => $location->location_id,
            'location_name' => $location->location_name,
            'monitoring_type' => $location->monitoringType->monitoring_types ?? '',
            'monitoring_id' => $location->monitoring_id,
            'existingData' => $existingData,
            'selectedDate' => $selectedDate,
            'editMode' => true,
        ]);
    }
}