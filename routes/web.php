<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JamaahController;
use App\Http\Controllers\EmbarkasiController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;
use App\Models\Jamaah;
use App\Models\Embarkasi;
use App\Models\Kas;
use App\Models\Transaksi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// TEST ROUTE
Route::get('/test', function () {
    return 'Test Route Working';
});

Route::get('/', function () {
    return 'Welcome to Travel Haji - System is Online';
});

Route::get('/dashboard', function () {
    $totalJamaah = Jamaah::count();
    $activeJamaah = Jamaah::where('status_keberangkatan', 'Belum Berangkat')->count();
    $upcomingDeparture = Embarkasi::where('status', 'Belum Berangkat')
                                  ->orderBy('waktu_keberangkatan', 'asc')
                                  ->first();
    
    // Simple Kas Summary
    $kasMasuk = Kas::where('jenis', 'DEBET')->sum('jumlah');
    $kasKeluar = Kas::where('jenis', 'KREDIT')->sum('jumlah');
    $saldo = $kasMasuk - $kasKeluar;

    return view('dashboard', compact('totalJamaah', 'activeJamaah', 'upcomingDeparture', 'saldo'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Jamaah Routes
    Route::resource('jamaah', JamaahController::class);

    // Embarkasi Routes
    Route::post('embarkasi/{id}/add-jamaah', [EmbarkasiController::class, 'addJamaah'])->name('embarkasi.add-jamaah');
    Route::delete('embarkasi/{id}/remove-jamaah/{jamaahId}', [EmbarkasiController::class, 'removeJamaah'])->name('embarkasi.remove-jamaah');
    Route::patch('embarkasi/{id}/update-status', [EmbarkasiController::class, 'updateStatus'])->name('embarkasi.update-status');
    Route::post('embarkasi/{id}/distribute-items/{jamaahId}', [EmbarkasiController::class, 'distributeItems'])->name('embarkasi.distribute-items');
    Route::post('embarkasi/{id}/upload-documents', [EmbarkasiController::class, 'uploadDocuments'])->name('embarkasi.upload-documents');
    Route::get('embarkasi/{id}/export-manifest', [EmbarkasiController::class, 'exportManifest'])->name('embarkasi.export-manifest');
    Route::resource('embarkasi', EmbarkasiController::class);

    // Price List Routes
    Route::resource('price-list', PriceListController::class);

    // Pegawai Routes
    Route::resource('pegawai', PegawaiController::class);

    // Passport Routes
    Route::patch('passport/{id}/update-status', [PassportController::class, 'updateStatus'])->name('passport.update-status');
    Route::resource('passport', PassportController::class);

    // Finance Routes
    Route::get('finance/report', [FinanceController::class, 'report'])->name('finance.report');
    Route::resource('finance', FinanceController::class);

    // Purchasing & Inventory Routes
    Route::resource('supplier', SupplierController::class);
    Route::resource('inventory', InventoryController::class);
    
    Route::post('purchasing/{id}/add-item', [PurchasingController::class, 'addItem'])->name('purchasing.add-item');
    Route::delete('purchasing/{id}/remove-item/{detailId}', [PurchasingController::class, 'removeItem'])->name('purchasing.remove-item');
    Route::resource('purchasing', PurchasingController::class);
});

require __DIR__.'/auth.php';
