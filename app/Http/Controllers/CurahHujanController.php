<?php

namespace App\Http\Controllers;

use App\Models\CurahHujan;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CurahHujanController extends Controller
{
    // Menampilkan daftar lokasi monitoring Curah Hujan dengan filter tanggal
    public function lokasiCurah(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // Ambil semua lokasi monitoring curah hujan yang aktif
        $lokasi_monitoring_curah_hujan = Location::with('monitoringType')
            ->where('monitoring_id', 22000003) // Curah Hujan
            ->where('status', 1) // Status aktif
            ->get();

        // Ambil data curah hujan pada tanggal yang dipilih, kelompokkan berdasarkan location_id
        $dataByDate = CurahHujan::whereRaw('DATE(created_at) = ?', [$selectedDate])
            ->get()
            ->groupBy('location_id');

        // Array untuk menyimpan status keterangan per lokasi
        $statusPerLokasi = [];

        // Menentukan status setiap lokasi berdasarkan data yang ada
        foreach ($lokasi_monitoring_curah_hujan as $location) {
            // Ambil SEMUA data untuk tanggal yang dipilih (tanpa filter field kosong)
            $allDataForDate = CurahHujan::where('location_id', $location->location_id)
                ->whereRaw('DATE(created_at) = ?', [$selectedDate])
                ->get();

            if ($allDataForDate->isEmpty()) {
                $statusPerLokasi[$location->location_id] = 'empty';
                continue;
            }

            // Cek field yang wajib diisi untuk curah hujan
            $requiredFields = ['CH', 'jam_mulai', 'jam_selesai'];
            
            $allComplete = true;
            $anyFilled = false;

            foreach ($allDataForDate as $record) {
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

        return view('mip.lokasi-curah', [
            'lokasi_monitoring_curah_hujan' => $lokasi_monitoring_curah_hujan,
            'dataByDate' => $dataByDate,
            'selectedDate' => $selectedDate,
            'statusPerLokasi' => $statusPerLokasi,
        ]);
    }

    // Tampilkan form tambah/edit data curah hujan dengan filter tanggal
    public function tambah_curah(Request $request)
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
            return redirect()->route('lokasi-curah')
                ->with('error', 'Parameter lokasi tidak valid');
        }

        // Debugging: Pastikan tanggal yang diterima benar
        \Log::info('=== TAMBAH CURAH HUJAN DEBUG START ===');
        \Log::info('Selected Date in tambah_curah: ' . $selectedDate);
        \Log::info('Location ID: ' . $location_id);
        \Log::info('Monitoring ID: ' . $monitoring_id);
        \Log::info('Query Parameters: ', $request->all());

        // Debug: Cek semua data untuk location dan monitoring_id ini
        $allDataForLocation = CurahHujan::where('location_id', $location_id)
            ->get(['id', 'CH', 'jam_mulai', 'jam_selesai', 'created_at']);
            
        \Log::info('All data for location ' . $location_id . ':');
        foreach($allDataForLocation as $data) {
            \Log::info('- ID: ' . $data->id . ', Date: ' . Carbon::parse($data->created_at)->toDateString() . ', CH: ' . ($data->CH ?? 'NULL') . ', Jam Mulai: ' . ($data->jam_mulai ?? 'NULL'));
        }

        // PERBAIKAN: Cari SEMUA data untuk tanggal yang dipilih (tanpa filter field kosong)
        // untuk menentukan apakah form dalam mode EDIT atau ADD
        $allDataForSelectedDate = CurahHujan::where('location_id', $location_id)
            ->whereRaw('DATE(created_at) = ?', [$selectedDate])
            ->get();

        \Log::info('All data for selected date ' . $selectedDate . ': ' . $allDataForSelectedDate->count() . ' records');

        $data_curah = null;

        if ($allDataForSelectedDate->isNotEmpty()) {
            // Ada data untuk tanggal ini - MODE EDIT
            // Ambil data pertama yang ditemukan (bisa yang lengkap atau tidak lengkap)
            $data_curah = $allDataForSelectedDate->first();
            
            \Log::info('EDIT MODE - Found existing data:');
            \Log::info('- ID: ' . $data_curah->id);
            \Log::info('- Created: ' . $data_curah->created_at);
            \Log::info('- CH: ' . ($data_curah->CH ?? 'NULL'));
            \Log::info('- Jam Mulai: ' . ($data_curah->jam_mulai ?? 'NULL'));
            \Log::info('- Jam Selesai: ' . ($data_curah->jam_selesai ?? 'NULL'));
        } else {
            // Tidak ada data untuk tanggal ini - MODE ADD
            $data_curah = null;
            \Log::info('ADD MODE - No data found for selected date');
        }

        \Log::info('=== TAMBAH CURAH HUJAN DEBUG END ===');

        // Kirim data ke view
        return view('mip.curah-hujan', [
            'location_id' => $location_id,
            'location_name' => $location_name,
            'monitoring_type' => $monitoring_type,
            'monitoring_id' => $monitoring_id,
            'data_curah' => $data_curah, // PERBAIKAN: Gunakan variable name yang konsisten
            'selectedDate' => $selectedDate,
        ]);
    }

    // Simpan data curah hujan
    public function store_curah(Request $request)
    {
        try {
            // Validasi input - hapus regex untuk lebih fleksibel
            $rules = [
                'CH' => 'nullable|numeric|min:0|max:999.99',
                'jam_mulai' => 'nullable|string',
                'jam_selesai' => 'nullable|string',
                'location_id' => 'required|integer|exists:locations,location_id',
                'monitoring_id' => 'required|integer',
                'selectedDate' => 'required|date',
            ];
            
            $messages = [
                'CH.numeric' => 'Nilai curah hujan harus berupa angka',
                'CH.min' => 'Nilai curah hujan tidak boleh negatif',
                'CH.max' => 'Nilai curah hujan maksimal 999.99 mm',
                'location_id.required' => 'Lokasi harus dipilih',
                'location_id.exists' => 'Lokasi tidak valid',
            ];
            
            $validatedData = $request->validate($rules, $messages);

            // Ambil nilai dari form dan normalize format waktu
            $CH = $validatedData['CH'] ?? null;
            $jamMulai = null;
            $jamSelesai = null;
            
            // Normalize jam mulai format - handle AM/PM and various formats
            if (!empty($validatedData['jam_mulai'])) {
                $time = trim($validatedData['jam_mulai']);
                // Replace dot with colon
                $time = str_replace('.', ':', $time);
                
                // Try to parse the time - strtotime handles AM/PM automatically
                $parsed = strtotime($time);
                if ($parsed !== false) {
                    $jamMulai = date('H:i', $parsed);
                } else {
                    // If parsing fails, try to clean and parse again
                    $time = preg_replace('/[^0-9:AaPpMm\s]/', '', $time);
                    $parsed = strtotime($time);
                    if ($parsed !== false) {
                        $jamMulai = date('H:i', $parsed);
                    } else {
                        $jamMulai = false; // Explicitly set to false if parsing fails
                    }
                }
            }
            
            // Normalize jam selesai format - handle AM/PM and various formats
            if (!empty($validatedData['jam_selesai'])) {
                $time = trim($validatedData['jam_selesai']);
                // Replace dot with colon
                $time = str_replace('.', ':', $time);
                
                // Try to parse the time - strtotime handles AM/PM automatically
                $parsed = strtotime($time);
                if ($parsed !== false) {
                    $jamSelesai = date('H:i', $parsed);
                } else {
                    // If parsing fails, try to clean and parse again
                    $time = preg_replace('/[^0-9:AaPpMm\s]/', '', $time);
                    $parsed = strtotime($time);
                    if ($parsed !== false) {
                        $jamSelesai = date('H:i', $parsed);
                    } else {
                        $jamSelesai = false; // Explicitly set to false if parsing fails
                    }
                }
            }

            // Cek apakah minimal satu field harus diisi
            // Note: CH bisa 0 (tidak ada hujan), jadi hanya cek null
            if (is_null($CH) && is_null($jamMulai) && is_null($jamSelesai)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Minimal isi salah satu field data');
            }
            
            // Validasi format waktu jika ada input waktu tapi gagal parsing
            if (!empty($validatedData['jam_mulai']) && $jamMulai === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Format jam mulai tidak valid');
            }
            
            if (!empty($validatedData['jam_selesai']) && $jamSelesai === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Format jam selesai tidak valid');
            }

            // Validasi jam mulai harus lebih awal dari jam selesai
            if (!is_null($jamMulai) && !is_null($jamSelesai) && $jamMulai !== false && $jamSelesai !== false) {
                // Convert to minutes for accurate comparison
                list($h1, $m1) = explode(':', $jamMulai);
                list($h2, $m2) = explode(':', $jamSelesai);
                $minutes1 = (int)$h1 * 60 + (int)$m1;
                $minutes2 = (int)$h2 * 60 + (int)$m2;
                
                if ($minutes1 >= $minutes2) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Jam selesai harus lebih besar dari jam mulai');
                }
            }

            \Log::info('=== STORE CURAH HUJAN DEBUG ===');
            \Log::info('Storing data for date: ' . $validatedData['selectedDate']);
            \Log::info('Location ID: ' . $validatedData['location_id']);
            \Log::info('CH Raw: ' . ($validatedData['CH'] ?? 'NULL'));
            \Log::info('Jam Mulai Raw: ' . ($validatedData['jam_mulai'] ?? 'NULL'));
            \Log::info('Jam Selesai Raw: ' . ($validatedData['jam_selesai'] ?? 'NULL'));
            \Log::info('CH Parsed: ' . ($CH ?? 'NULL'));
            \Log::info('Jam Mulai Parsed: ' . ($jamMulai ?? 'NULL'));
            \Log::info('Jam Selesai Parsed: ' . ($jamSelesai ?? 'NULL'));

            // Cek apakah sudah ada data untuk tanggal ini
            $existingDataAny = CurahHujan::where('location_id', $validatedData['location_id'])
                ->whereRaw('DATE(created_at) = ?', [$validatedData['selectedDate']])
                ->first();

            if ($existingDataAny) {
                // UPDATE data yang sudah ada
                $existingDataAny->update([
                    'CH' => $CH !== null ? $CH : $existingDataAny->CH,
                    'jam_mulai' => $jamMulai !== null && $jamMulai !== false ? $jamMulai : $existingDataAny->jam_mulai,
                    'jam_selesai' => $jamSelesai !== null && $jamSelesai !== false ? $jamSelesai : $existingDataAny->jam_selesai,
                    'updated_at' => now(),
                ]);
                $message = 'Data berhasil diperbarui';
                \Log::info('Updated existing data with ID: ' . $existingDataAny->id);
            } else {
                // CREATE data baru
                $curah = new CurahHujan();
                $curah->CH = $CH;
                $curah->jam_mulai = $jamMulai !== false ? $jamMulai : null;
                $curah->jam_selesai = $jamSelesai !== false ? $jamSelesai : null;
                $curah->location_id = $validatedData['location_id'];
                $curah->monitoring_id = $validatedData['monitoring_id'];
                $curah->created_at = $validatedData['selectedDate'] . ' ' . now()->format('H:i:s');
                $curah->updated_at = now();
                $curah->save();

                $message = 'Data berhasil disimpan';
                \Log::info('Created new data with ID: ' . $curah->id);
            }

            return redirect()->route('lokasi-curah', ['date' => $validatedData['selectedDate']])
                ->with('success', $message);
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap error validasi dan kirim kembali dengan pesan error
            $errors = $e->validator->errors();
            $errorMessage = $errors->first();
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            \Log::error('Error in store_curah: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    // Edit data curah hujan (menggunakan form tambah untuk konsistensi)
    public function edit_curah(Request $request)
    {
        return $this->tambah_curah($request);
    }

    // Update data curah hujan
    public function update_curah(Request $request, $id)
    {
        try {
            // Validasi input - hapus regex untuk lebih fleksibel
            $rules = [
                'CH' => 'nullable|numeric|min:0|max:999.99',
                'jam_mulai' => 'nullable|string',
                'jam_selesai' => 'nullable|string',
                'selectedDate' => 'required|date',
            ];
            
            $messages = [
                'CH.numeric' => 'Nilai curah hujan harus berupa angka',
                'CH.min' => 'Nilai curah hujan tidak boleh negatif',
                'CH.max' => 'Nilai curah hujan maksimal 999.99 mm',
            ];
            
            $validatedData = $request->validate($rules, $messages);

            // Ambil nilai dari form dan normalize format waktu
            $CH = $validatedData['CH'] ?? null;
            $jamMulai = null;
            $jamSelesai = null;
            
            // Normalize jam mulai format - handle AM/PM and various formats
            if (!empty($validatedData['jam_mulai'])) {
                $time = trim($validatedData['jam_mulai']);
                // Replace dot with colon
                $time = str_replace('.', ':', $time);
                
                // Try to parse the time - strtotime handles AM/PM automatically
                $parsed = strtotime($time);
                if ($parsed !== false) {
                    $jamMulai = date('H:i', $parsed);
                } else {
                    // If parsing fails, try to clean and parse again
                    $time = preg_replace('/[^0-9:AaPpMm\s]/', '', $time);
                    $parsed = strtotime($time);
                    if ($parsed !== false) {
                        $jamMulai = date('H:i', $parsed);
                    } else {
                        $jamMulai = false; // Explicitly set to false if parsing fails
                    }
                }
            }
            
            // Normalize jam selesai format - handle AM/PM and various formats
            if (!empty($validatedData['jam_selesai'])) {
                $time = trim($validatedData['jam_selesai']);
                // Replace dot with colon
                $time = str_replace('.', ':', $time);
                
                // Try to parse the time - strtotime handles AM/PM automatically
                $parsed = strtotime($time);
                if ($parsed !== false) {
                    $jamSelesai = date('H:i', $parsed);
                } else {
                    // If parsing fails, try to clean and parse again
                    $time = preg_replace('/[^0-9:AaPpMm\s]/', '', $time);
                    $parsed = strtotime($time);
                    if ($parsed !== false) {
                        $jamSelesai = date('H:i', $parsed);
                    } else {
                        $jamSelesai = false; // Explicitly set to false if parsing fails
                    }
                }
            }

            // Cek apakah minimal salah satu field harus diisi
            // Note: CH bisa 0 (tidak ada hujan), jadi hanya cek null
            if (is_null($CH) && is_null($jamMulai) && is_null($jamSelesai)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Minimal isi salah satu field data');
            }
            
            // Validasi format waktu jika ada input waktu tapi gagal parsing
            if (!empty($validatedData['jam_mulai']) && $jamMulai === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Format jam mulai tidak valid');
            }
            
            if (!empty($validatedData['jam_selesai']) && $jamSelesai === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Format jam selesai tidak valid');
            }

            // Validasi jam mulai harus lebih awal dari jam selesai
            if (!is_null($jamMulai) && !is_null($jamSelesai) && $jamMulai !== false && $jamSelesai !== false) {
                // Convert to minutes for accurate comparison
                list($h1, $m1) = explode(':', $jamMulai);
                list($h2, $m2) = explode(':', $jamSelesai);
                $minutes1 = (int)$h1 * 60 + (int)$m1;
                $minutes2 = (int)$h2 * 60 + (int)$m2;
                
                if ($minutes1 >= $minutes2) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Jam selesai harus lebih besar dari jam mulai');
                }
            }

            $curah = CurahHujan::findOrFail($id);

            \Log::info('=== UPDATE CURAH HUJAN DEBUG ===');
            \Log::info('Updating data ID: ' . $id);
            \Log::info('Selected Date: ' . $validatedData['selectedDate']);
            \Log::info('CH Raw: ' . ($validatedData['CH'] ?? 'NULL'));
            \Log::info('Jam Mulai Raw: ' . ($validatedData['jam_mulai'] ?? 'NULL'));
            \Log::info('Jam Selesai Raw: ' . ($validatedData['jam_selesai'] ?? 'NULL'));
            \Log::info('New CH: ' . ($CH ?? 'NULL'));
            \Log::info('New Jam Mulai: ' . ($jamMulai ?? 'NULL'));
            \Log::info('New Jam Selesai: ' . ($jamSelesai ?? 'NULL'));
            \Log::info('Current data - CH: ' . ($curah->CH ?? 'NULL') . ', Jam Mulai: ' . ($curah->jam_mulai ?? 'NULL') . ', Created: ' . $curah->created_at);

            // Update data
            $curah->update([
                'CH' => $CH !== null ? $CH : $curah->CH,
                'jam_mulai' => $jamMulai !== null && $jamMulai !== false ? $jamMulai : $curah->jam_mulai,
                'jam_selesai' => $jamSelesai !== null && $jamSelesai !== false ? $jamSelesai : $curah->jam_selesai,
                'updated_at' => now(),
            ]);

            \Log::info('Data successfully updated');

            return redirect()->route('lokasi-curah', ['date' => $validatedData['selectedDate']])
                ->with('success', 'Data berhasil diperbarui');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap error validasi dan kirim kembali dengan pesan error
            $errors = $e->validator->errors();
            $errorMessage = $errors->first();
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            \Log::error('Error in update_curah: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }
}