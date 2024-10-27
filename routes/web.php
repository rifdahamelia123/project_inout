<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController; // Jika menggunakan controller ini
use App\Http\Controllers\DashboardSimpaduController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\LogMasukController;
use App\Http\Controllers\LogKeluarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda.
| Semua rute ini akan dimuat oleh RouteServiceProvider dan akan
| ditetapkan ke grup middleware "web".
|
*/

// Default route, mengarahkan ke halaman login
Route::get('/', function () {
    return view('pages.auth.auth-login', ['type_menu' => '']);
    })->name('auth.login');


    // Route Barang (CRUD dan Search) dengan proteksi middleware auth
    Route::middleware(['auth'])->group(function () {

    

    // Menampilkan daftar barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

    // Form tambah barang
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::get('/barang/import', [BarangController::class, 'import'])->name('barang.import');
    Route::post('/barang/import', [ExcelController::class, 'importBarang'])->name('barang.importBarang');

    

    // Hapus barang
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    // edit barang
    Route::get('/barang/edit/{kode_barang}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    

    // Menyimpan barang baru
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

    // Mencari barang
    Route::get('/barang/search', [BarangController::class, 'search'])->name('barang.search');


    // Traffic barang masuk
    Route::get('/barang_masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::get('barang_masuk/search', [BarangMasukController::class, 'search'])->name('barang_masuk.search');
    Route::post('/barang_masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
    Route::get('/barang_masuk/create', [BarangMasukController::class, 'create'])->name('barang_masuk.create');
    Route::get('barang_masuk/import', [BarangMasukController::class, 'import'])->name('barang_masuk.import');
    Route::post('barang_masuk/import', [BarangMasukController::class, 'importStore'])->name('barang_masuk.import.store');
    Route::get('/barang_masuk/edit/{kode_barang}', [BarangMasukController::class, 'edit'])->name('barang_masuk.edit');
    Route::get('/barang_masuk/{id}/tambah', [BarangMasukController::class, 'tambah'])->name('barang_masuk.tambah');
    Route::get('barang_masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::get('barang_masuk/export', [BarangMasukController::class, 'export'])->name('barang_masuk.export');

    // Export barang keluar masuk
    //Route::get('/export-barang-masuk', [BarangMasukController::class, 'exportBarangMasuk']);
    //Route::get('/export-barang-keluar', [BarangKeluarController::class, 'exportBarangKeluar']);


    // Trafic barang keluar
    Route::get('/barang_keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::post('/barang_keluar', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');
    Route::get('barang_keluar/search', [BarangKeluarController::class, 'search'])->name('barang_keluar.search');
    Route::get('/barang_keluar/create', [BarangKeluarController::class, 'create'])->name('barang_keluar.create');
    Route::get('barang_keluar/import', [BarangKeluarController::class, 'import'])->name('barang_keluar.import');
    Route::post('barang_keluar/import', [BarangKeluarController::class, 'importStore'])->name('barang_keluar.import.store');
    Route::get('/barang_keluar/{id}/tambah', [BarangKeluarController::class, 'tambah'])->name('barang_keluar.tambah');
    Route::delete('/barang_keluar/{kode_barang}', [BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');
    Route::get('barang_keluar/{kode_barang}/edit', [BarangKeluarController::class, 'edit'])->name('barang_keluar.edit');
    Route::get('barang_keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::get('barang_keluar/export', [BarangKeluarController::class, 'export'])->name('barang_keluar.export');
    Route::get('/get-nama-barang/{kode_barang}', [BarangController::class, 'getNamaBarang']);

    
    //Route::get('/barang_keluar/edit/{kode_barang}', [BarangKeluarController::class, 'edit'])->name('barang_keluar.edit');
    //Route::put('/barang_keluar/{kode_barang}/kurang', [BarangKeluarController::class, 'kurang'])->name('barang_keluar.kurang');


    // Log
    //Route::get('/log_masuk', [LogMasukController::class, 'index'])->name('log_masuk.index');
    //Route::get('/log_keluar', [LogKeluarController::class, 'index'])->name('log_keluar.index');

    });

        // Route untuk dashboard setelah login
        Route::middleware(['auth'])->group(function () {
        Route::get('/home', [DashboardSimpaduController::class, 'index'])->name('home');
        Route::get('/dashboard-simpadu', [DashboardSimpaduController::class, 'index'])->name('dashboard-simpadu.index');
        Route::get('/dashboard-simpadu/import', [DashboardSimpaduController::class, 'import'])->name('dashboard-simpadu.import');
        Route::post('/dashboard-simpadu/import', [DashboardSimpaduController::class, 'importStore'])->name('dashboard-simpadu.import.store');
        Route::get('/home', [DashboardSimpaduController::class, 'index'])->name('home');
        Route::get('/dashboard-simpadu/search', [DashboardSimpaduController::class, 'search'])->name('dashboard-simpadu.search');
        Route::get('/dashboard-simpadu/export', [DashboardSimpaduController::class, 'export'])->name('dashboard-simpadu.export');
        
 
    });

/*
|--------------------------------------------------------------------------
| Optional Auth Routes (Opsional)
|--------------------------------------------------------------------------
| Jika ingin menggunakan route ini, pastikan view-view terkait sudah ada.
| Ini adalah contoh rute tambahan untuk fitur otentikasi lainnya.
|
*/



// Route::get('/register', function () {
//     return view('pages.auth.auth-register');
// })->name('register');

// Route::get('/forgot', function () {
//     return view('pages.auth.auth-forgot-password');
// })->name('forgot');

// Route::get('/reset', function () {
//     return view('pages.auth.auth-reset-password');
// })->name('reset');
