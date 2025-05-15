<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MonitoringTypeController;
use App\Http\Controllers\AirLimbahTambangController;
use App\Http\Controllers\CurahHujanController;
use App\Http\Controllers\OilTrapFuelTrapController;
use App\Http\Controllers\DebuController;
use App\Http\Controllers\KebisinganController;
use App\Http\Controllers\MaintainUserController;
use App\Http\Controllers\MaintainLokasiController;
use App\Http\Controllers\AuthController;

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route (Mip Role)
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'indexMip'])->name('dashboard');

// Admin Routes (Role: admin)
Route::middleware(['Role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');

    // === MAINTAIN USER ===
    Route::get('/maintainuser', [MaintainUserController::class, 'index'])->name('admin.maintainuser');
    Route::post('/store-user', [MaintainUserController::class, 'store'])->name('admin.storeuser');
    Route::get('/edit-user/{id}', [MaintainUserController::class, 'edit'])->name('admin.edituser');
    Route::put('/update-user/{user_id}', [MaintainUserController::class, 'update'])->name('admin.updateuser');
    Route::delete('/delete-user/{id}', [MaintainUserController::class, 'destroy'])->name('admin.deleteuser');

    // === MAINTAIN LOKASI ===
    Route::get('/maintainlokasi', [MaintainLokasiController::class, 'maintainlokasi'])->name('admin.maintainlokasi');
    Route::post('/store-lokasi', [MaintainLokasiController::class, 'store'])->name('admin.storelokasi');
    Route::get('/edit-lokasi/{location_id}', [MaintainLokasiController::class, 'edit'])->name('admin.editlokasi');
    Route::put('/update-lokasi/{location_id}', [MaintainLokasiController::class, 'update'])->name('admin.updatelokasi');
    Route::delete('/delete-lokasi/{location_id}', [MaintainLokasiController::class, 'destroy'])->name('admin.deletelokasi');
});

// Routes for MIP Role
Route::middleware(['Role:mip'])->group(function () {
    Route::get('/mip-dashboard', [DashboardController::class, 'indexMip'])->name('mip.dashboard');

    Route::get('/lokasi-limbah', [PemantauanController::class, 'lokasiLimbah'])->name('lokasi-limbah');
    Route::get('/lokasi-oilfuel', [PemantauanController::class, 'lokasioilfuel'])->name('lokasi-oilfuel');

    // Add/Edit Routes for Oilfuel and Air Limbah
    Route::get('/edit-oilfuel', [OilTrapFuelTrapController::class, 'edit_oilfuel'])->name('edit.oilfuel');
    Route::get('/edit-limbah', [AirLimbahTambangController::class, 'tambah_limbah'])->name('edit.limbah');

    // Store Routes for Limba, Oilfuel, etc.
    Route::post('/store-limbah', [AirLimbahTambangController::class, 'store_limbah'])->name('store.limbah');
    Route::get('/tambah-limbah', [AirLimbahTambangController::class, 'tambah_limbah'])->name('tambah.limbah');
    Route::post('/store-oilfuel', [OilTrapFuelTrapController::class, 'store_oilfuel'])->name('store.oilfuel');
    Route::get('/tambah-oilfuel', [OilTrapFuelTrapController::class, 'tambah_oilfuel'])->name('tambah.oilfuel');

    // Update Routes for Limbah
    Route::post('/update-limbah', [AirLimbahTambangController::class, 'update_limbah'])->name('update.limbah');
    Route::get('/lokasi-limbah', [AirLimbahTambangController::class, 'lokasiLimbah'])->name('lokasi-limbah');

    // Route edit curah hujan (akan redirect ke method tambah_curah agar form bisa terisi data lama)
    Route::get('/edit-curah', [CurahHujanController::class, 'edit_curah'])->name('edit.curah');

    // Route update data curah hujan (method PUT)
    Route::put('/update-curah/{id}', [CurahHujanController::class, 'update_curah'])->name('update.curah');

    Route::get('/edit-limbah/{id}', [AirLimbahTambangController::class, 'edit_limbah'])->name('edit.limbah');
    Route::put('/update-limbah/{id}', [AirLimbahTambangController::class, 'update_limbah'])->name('update.limbah');


    Route::get('/lokasi-debu', [DebuController::class, 'lokasiDebu'])->name('lokasi-debu');
    Route::get('/tambah-debu', [DebuController::class, 'tambah_debu'])->name('tambah.debu');
    Route::get('/edit-debu', [DebuController::class, 'tambah_debu'])->name('edit.debu');  // <<< ini tambahan
    Route::post('/store-debu', [DebuController::class, 'store_debu'])->name('store.debu');
    Route::put('/update-debu/{id}', [DebuController::class, 'update_debu'])->name('update.debu');
    Route::get('/limbah/edit/{location_id}', [AirLimbahTambangController::class, 'edit_limbah'])->name('edit.limbah');
    Route::put('/limbah/update/{id}', [AirLimbahTambangController::class, 'update_limbah'])->name('update.limbah');


    
=======
    Route::put('/debu/update/{id}', [DebuController::class, 'update'])->name('update.debu');

    Route::get('/debu/form', [DebuController::class, 'tambah_debu'])->name('form.debu');
    Route::post('/debu/store', [DebuController::class, 'store_debu'])->name('store.debu');
    Route::get('/lokasi-debu', [DebuController::class, 'lokasiDebu'])->name('lokasi.debu');
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
});

// Routes for Other Monitoring Types
Route::middleware(['Role:mitra_kerja'])->group(function () {
    // Add routes specific for 'mitra_kerja' Role if needed
});

Route::middleware(['Role:supervisor'])->group(function () {
    // Add routes specific for 'supervisor' Role if needed
});

// Routes for Various Monitoring Types
Route::get('/curah-hujan', [PemantauanController::class, 'curahHujan'])->name('curah-hujan');
Route::get('/debu', [PemantauanController::class, 'debu'])->name('debu');
Route::get('/kebisingan', [PemantauanController::class, 'kebisingan'])->name('kebisingan');
Route::get('/limbah-tambang', [PemantauanController::class, 'limbahTambang'])->name('limbah-tambang');
Route::get('/oilfuel-trap', [PemantauanController::class, 'oilfuelTrap'])->name('oilfuel-trap');

// Routes for Locations (e.g. curah hujan, debu, etc.)
Route::get('/lokasi-curah', [PemantauanController::class, 'lokasiCurah'])->name('lokasi-curah');
Route::get('/lokasi-debu', [PemantauanController::class, 'lokasiDebu'])->name('lokasi-debu');
Route::get('/lokasi-kebisingan', [PemantauanController::class, 'lokasiKebisingan'])->name('lokasi-kebisingan');

// Routes for Monitoring Types
Route::get('/monitoring-types', [MonitoringTypeController::class, 'index'])->name('monitoring-types.index');
Route::get('/monitoring-types/{id}', [MonitoringTypeController::class, 'show'])->name('monitoring-types.show');

// Additional Monitoring Routes
Route::get('/air-limbah-tambang', [AirLimbahTambangController::class, 'index'])->name('air-limbah-tambang');
Route::get('/curah-hujan', [CurahHujanController::class, 'index'])->name('curah-hujan');
Route::get('/oil-trap-fuel-trap', [OilTrapFuelTrapController::class, 'index'])->name('oil-trap-fuel-trap');
Route::get('/debu', [DebuController::class, 'index'])->name('debu');
Route::get('/kebisingan', [KebisinganController::class, 'index'])->name('kebisingan');

// Routes for Adding New Entries (Limbah, OilFuel, Curah, Debu, Kebisingan)
Route::get('/tambah-oilfuel', [OilTrapFuelTrapController::class, 'tambah_oilfuel'])->name('tambah.oilfuel');
Route::post('/store-oilfuel', [OilTrapFuelTrapController::class, 'store_oilfuel'])->name('store.oilfuel');

Route::get('/tambah-curah', [CurahHujanController::class, 'tambah_curah'])->name('tambah.curah');
Route::post('/store-curah', [CurahHujanController::class, 'store_curah'])->name('store.curah');

Route::get('/tambah-debu', [DebuController::class, 'tambah_debu'])->name('tambah.debu');
Route::post('/store-debu', [DebuController::class, 'store_debu'])->name('store.debu');

Route::get('/tambah-kebisingan', [KebisinganController::class, 'tambah_kebisingan'])->name('tambah.kebisingan');
Route::post('/store-kebisingan', [KebisinganController::class, 'store_kebisingan'])->name('store.kebisingan');

// Admin Routes for User Management
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/maintain-user', [MaintainUserController::class, 'index'])->name('admin.maintainuser');
    Route::get('/edit-user/{id}', [MaintainUserController::class, 'edit'])->name('admin.edituser');
    Route::post('/update-user/{id}', [MaintainUserController::class, 'update'])->name('admin.updateuser');
    Route::delete('/delete-user/{id}', [MaintainUserController::class, 'destroy'])->name('admin.deleteuser');
});
