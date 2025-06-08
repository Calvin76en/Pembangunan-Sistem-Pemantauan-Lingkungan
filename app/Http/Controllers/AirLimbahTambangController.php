<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\AirLimbahTambang;
use Illuminate\Support\Facades\DB;

class AirLimbahTambangController extends Controller
{
    // Tampilkan semua lokasi monitoring air limbah
    public function lokasiLimbah(Request $request)
    {
        // Ambil tanggal dari query string, default hari ini
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Ambil data lokasi monitoring_id = 1 dan status aktif
        $lokasi = Location::with('monitoringType')
            ->where('monitoring_id', 22000001) // Gunakan monitoring_id yang sesuai
            ->where('status', 1)
            ->get();

        // Ambil data Air Limbah per lokasi di tanggal terpilih
        $dataByDate = AirLimbahTambang::whereDate('created_at', $selectedDate)
            ->get()
            ->keyBy('location_id');

        return view('mip.lokasi-limbah', [
            'lokasi' => $lokasi,
            'dataByDate' => $dataByDate,
            'selectedDate' => $selectedDate,
        ]);
    }

    // Tampilkan form tambah/edit
    public function tambah_limbah(Request $request)
    {
        $location_id = $request->query('location_id');
        $selectedDate = $request->query('date', now()->toDateString());

        if (!$location_id) {
            abort(404, 'Location ID tidak ditemukan');
        }

        // Query data sesuai location_id dan tanggal selectedDate
        $data_limbah = AirLimbahTambang::where('location_id', $location_id)
            ->whereDate('created_at', $selectedDate)    // Pastikan filter tanggal diterapkan di sini
            ->first();

        $location = Location::with('monitoringType')->find($location_id);

        if (!$location) {
            abort(404, 'Lokasi tidak ditemukan');
        }

        return view('mip.limbah-tambang', [
            'location_id' => $location_id,
            'location_name' => $location->location_name,
            'monitoring_type' => $location->monitoringType->monitoring_types ?? '',
            'monitoring_id' => $location->monitoring_id ?? 1,
            'data_limbah' => $data_limbah,
            'selectedDate' => $selectedDate,
        ]);
    }

    // Fungsi untuk validasi nilai pH
    private function validatePHValues($data)
    {
        $errors = [];
        $phFields = [
            'ph_inlet' => 'pH Inlet',
            'ph_outlet_1' => 'pH Outlet 1',
            'ph_outlet_2' => 'pH Outlet 2'
        ];

        foreach ($phFields as $field => $label) {
            $value = $data[$field] ?? null;
            
            if (!is_null($value) && $value !== '') {
                $numericValue = floatval($value);
                
                if (!is_numeric($value)) {
                    $errors[] = "$label: '$value' bukan angka yang valid. Tolong masukkan nilai pH yang valid antara 6.0 - 9.0.";
                } elseif ($numericValue < 6) {
                    $errors[] = "$label: $value terlalu rendah (< 6.0). Tolong masukkan nilai pH yang valid antara 6.0 - 9.0.";
                } elseif ($numericValue > 9) {
                    $errors[] = "$label: $value terlalu tinggi (> 9.0). Tolong masukkan nilai pH yang valid antara 6.0 - 9.0.";
                }
            }
        }

        return $errors;
    }

    // Fungsi untuk menyimpan atau mengupdate data limbah
    public function store_limbah(Request $request)
    {
        $selectedDate = $request->input('selectedDate');

        // Validasi pH custom terlebih dahulu
        $phErrors = $this->validatePHValues($request->all());
        
        if (!empty($phErrors)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nilai tidak valid! ' . implode(' ', $phErrors));
        }

        $validatedData = $request->validate([
            'ph_inlet' => 'nullable|numeric|between:6,9',
            'ph_outlet_1' => 'nullable|numeric|between:6,9',
            'ph_outlet_2' => 'nullable|numeric|between:6,9',
            'treatment_kapur' => 'nullable|numeric',
            'treatment_pac' => 'nullable|numeric',
            'treatment_tawas' => 'nullable|numeric',
            'tss_inlet' => 'nullable|numeric',
            'tss_outlet' => 'nullable|numeric',
            'fe_outlet' => 'nullable|numeric',
            'mn_outlet' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'velocity' => 'nullable|numeric',
            'location_id' => 'required|integer',
            'monitoring_id' => 'required|integer|in:22000001', // Validasi ID monitoring
            'keterangan' => 'nullable|string|max:255',
        ], [
            // Pesan error yang lebih spesifik
            'ph_inlet.between' => 'pH Inlet: Nilai tidak valid! Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_1.between' => 'pH Outlet 1: Nilai tidak valid! Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_2.between' => 'pH Outlet 2: Nilai tidak valid! Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_inlet.numeric' => 'pH Inlet: Nilai tidak valid! Harus berupa angka. Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_1.numeric' => 'pH Outlet 1: Nilai tidak valid! Harus berupa angka. Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_2.numeric' => 'pH Outlet 2: Nilai tidak valid! Harus berupa angka. Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'location_id.required' => 'Location ID harus diisi.',
            'monitoring_id.required' => 'Monitoring ID harus diisi.',
            'monitoring_id.in' => 'Monitoring ID tidak valid.',
        ]);

        // Cek apakah id sudah ada (update) atau baru (insert)
        if (!empty($validatedData['id'])) {
            // Update data limbah existing
            $limbah = AirLimbahTambang::find($validatedData['id']);
            if ($limbah) {
                $limbah->update($validatedData);
                $limbah->created_at = $selectedDate . ' 00:00:00';
                $limbah->updated_at = now();
                $limbah->save();
            }
        } else {
            // Simpan data limbah baru
            $limbah = new AirLimbahTambang($validatedData);
            $limbah->created_at = $selectedDate . ' 00:00:00';
            $limbah->updated_at = now();
            $limbah->save();
        }

        // Menghitung jumlah field yang terisi untuk tanggal yang dipilih
        $fieldCount = AirLimbahTambang::whereDate('created_at', $selectedDate)
            ->where('location_id', $validatedData['location_id'])
            ->whereNotNull('ph_inlet')
            ->whereNotNull('ph_outlet_1')
            ->whereNotNull('ph_outlet_2')
            ->whereNotNull('treatment_kapur')
            ->whereNotNull('treatment_pac')
            ->whereNotNull('treatment_tawas')
            ->whereNotNull('tss_inlet')
            ->whereNotNull('tss_outlet')
            ->whereNotNull('fe_outlet')
            ->whereNotNull('mn_outlet')
            ->whereNotNull('debit')
            ->whereNotNull('velocity')
            ->count();

        // Tentukan status keterangan berdasarkan jumlah field yang terisi
        $status_keterangan = match (true) {
            $fieldCount === 0 => 'empty',
            $fieldCount < 12 => 'draft',  // Ganti 12 dengan jumlah total field input yang sesuai
            default => 'completed',
        };

        // Hitung berapa banyak field pH yang valid
        $validPHCount = 0;
        $phFields = ['ph_inlet', 'ph_outlet_1', 'ph_outlet_2'];
        foreach ($phFields as $field) {
            if (!empty($validatedData[$field])) {
                $validPHCount++;
            }
        }

        $successMessage = 'Data limbah berhasil disimpan!';
        if ($validPHCount > 0) {
            $successMessage .= " Semua nilai pH ($validPHCount field) valid dan dalam rentang yang benar (6.0 - 9.0).";
        }
        $successMessage .= " Status: $status_keterangan";

        return redirect()->route('mip-lokasi-limbah', ['date' => $selectedDate])
            ->with('success', $successMessage);
    }

    // Fungsi untuk mengedit data limbah
    public function edit_limbah(Request $request, $location_id)
    {
        $selectedDate = $request->query('date', now()->toDateString());

        // Ambil data limbah berdasarkan location_id dan tanggal selectedDate dengan urutan terbaru
        $data_limbah = AirLimbahTambang::where('location_id', $location_id)
            ->whereDate('created_at', $selectedDate)
            ->orderBy('created_at', 'desc') // ambil yang paling baru
            ->first();

        if (!$data_limbah) {
            return redirect()->route('tambah.limbah', [
                'location_id' => $location_id,
                'date' => $selectedDate,
                'location_name' => Location::where('location_id', $location_id)->value('location_name'),
                'monitoring_type' => Location::where('location_id', $location_id)->with('monitoringType')->first()->monitoringType->monitoring_types ?? '',
                'monitoring_id' => Location::where('location_id', $location_id)->value('monitoring_id'),
            ])->with('info', 'Data limbah belum ada untuk tanggal ini, silakan tambah data.');
        }

        $location = Location::find($location_id);
        if (!$location) {
            abort(404, 'Lokasi tidak ditemukan');
        }

        $monitoringType = $location->monitoringType;
        if (!$monitoringType) {
            abort(404, 'Monitoring type tidak ditemukan');
        }

        $location_name = $location->location_name;
        $monitoring_type = $monitoringType->monitoring_types;
        $monitoring_id = $location->monitoring_id;

        return view('mip.limbah-tambang', compact(
            'data_limbah',
            'location_id',
            'location_name',
            'monitoring_type',
            'monitoring_id',
            'selectedDate'
        ));
    }

    // Fungsi untuk memperbarui data limbah
    public function update_limbah(Request $request, $id)
    {
        // Validasi pH custom terlebih dahulu
        $phErrors = $this->validatePHValues($request->all());
        
        if (!empty($phErrors)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nilai tidak valid! ' . implode(' ', $phErrors));
        }

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'ph_inlet' => 'nullable|numeric|between:6,9',
            'ph_outlet_1' => 'nullable|numeric|between:6,9',
            'ph_outlet_2' => 'nullable|numeric|between:6,9',
            'treatment_kapur' => 'nullable|numeric',
            'treatment_pac' => 'nullable|numeric',
            'treatment_tawas' => 'nullable|numeric',
            'tss_inlet' => 'nullable|numeric',
            'tss_outlet' => 'nullable|numeric',
            'fe_outlet' => 'nullable|numeric',
            'mn_outlet' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'velocity' => 'nullable|numeric',
            'keterangan' => 'nullable|string|max:255',
        ], [
            // Pesan error yang lebih spesifik
            'ph_inlet.between' => 'pH Inlet: Nilai tidak valid! Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_1.between' => 'pH Outlet 1: Nilai tidak valid! Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_2.between' => 'pH Outlet 2: Nilai tidak valid! Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_inlet.numeric' => 'pH Inlet: Nilai tidak valid! Harus berupa angka. Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_1.numeric' => 'pH Outlet 1: Nilai tidak valid! Harus berupa angka. Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
            'ph_outlet_2.numeric' => 'pH Outlet 2: Nilai tidak valid! Harus berupa angka. Tolong masukkan inputan yang valid dengan rentang pH antara 6.0 - 9.0.',
        ]);

        // Temukan data berdasarkan ID
        $limbah = AirLimbahTambang::findOrFail($id);
        $limbah->update($validatedData);

        // Hitung jumlah field yang terisi untuk menentukan status
        $fieldCount = collect($validatedData)
            ->filter(fn($v) => !is_null($v) && $v !== '')
            ->count();

        // Tentukan status keterangan berdasarkan jumlah field yang terisi
        $status_keterangan = match (true) {
            $fieldCount === 0 => 'empty',
            $fieldCount < 12 => 'draft',  // Ganti 12 dengan jumlah total field input yang sesuai
            default => 'completed',
        };

        // Hitung berapa banyak field pH yang valid yang di-update
        $validPHCount = 0;
        $phFields = ['ph_inlet', 'ph_outlet_1', 'ph_outlet_2'];
        foreach ($phFields as $field) {
            if (!empty($validatedData[$field])) {
                $validPHCount++;
            }
        }

        $successMessage = 'Data limbah berhasil diperbarui!';
        if ($validPHCount > 0) {
            $successMessage .= " Semua nilai pH ($validPHCount field) valid dan dalam rentang yang benar (6.0 - 9.0).";
        }
        $successMessage .= " Status: $status_keterangan";

        // Redirect kembali dengan pesan sukses
        return redirect()->route('mip-lokasi-limbah', ['date' => $request->input('selectedDate')])
            ->with('success', $successMessage);
    }
}