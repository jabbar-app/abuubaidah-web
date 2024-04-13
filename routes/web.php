<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BilhaqController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FaiController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KibaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LughohController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StebisController;
use App\Http\Controllers\TahfizController;
use App\Http\Controllers\TahsinController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('student.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-program', [DashboardController::class, 'myProgram'])->name('my.program');
    Route::get('/my-transaction', [DashboardController::class, 'myTransaction'])->name('my.transaction');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/{userId}/roles', [UserController::class, 'roleManagement'])->name('users.roleManagement');
    Route::post('/users/{user}/assignRole', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::delete('/users/{user}/role/{role}', [UserController::class, 'removeRole'])->name('users.removeRole');

    Route::controller(PaymentController::class)->group(function () {
        Route::post('/create-invoice-selection', 'createInvoiceSelection')->name('program.selection');
        Route::post('/invoice/regenerate/{externalId}', 'regenerateInvoice')->name('invoice.regenerate');
        Route::delete('/invoice/delete/{id}', 'destroy')->name('invoice.destroy');
    });
    Route::resource('payments', PaymentController::class);

    Route::resource('/users', UserController::class);
    Route::resource('results', ResultController::class);
    Route::resource('/tahsins', TahsinController::class);
    Route::resource('/tahfizs', TahfizController::class);
    Route::resource('/bilhaqs', BilhaqController::class);
    Route::resource('/kibas', KibaController::class);
    Route::resource('/lughohs', LughohController::class);
    Route::resource('/fais', FaiController::class);
    Route::resource('/programs', ProgramController::class);
    Route::resource('/helps', HelpController::class);
    Route::get('/laporan', [HelpController::class, 'indexHelp'])->name('student.helps.index');
    Route::get('/laporan/buat', [HelpController::class, 'createHelp'])->name('student.helps.create');
    Route::post('/laporan/simpan', [HelpController::class, 'storeHelp'])->name('student.helps.store');
    Route::get('/laporan/{help}', [HelpController::class, 'showHelp'])->name('student.helps.show');
    Route::get('/laporan/edit/{help}', [HelpController::class, 'editHelp'])->name('student.helps.edit');
    Route::post('/laporan/edit/{help}', [HelpController::class, 'updateHelp'])->name('student.helps.update');

    Route::get('/stebis', [StebisController::class, 'index'])->name('stebis.index');
    Route::post('/stebis', [StebisController::class, 'store'])->name('stebis.store');
    Route::get('/stebis/create', [StebisController::class, 'create'])->name('stebis.create');
    Route::get('/stebis/{stebis}', [StebisController::class, 'show'])->name('stebis.show');
    Route::put('/stebis/{stebis}', [StebisController::class, 'update'])->name('stebis.update');
    Route::delete('/stebis/{stebis}', [StebisController::class, 'destroy'])->name('stebis.destroy');
    Route::get('/stebis/{stebis}/edit', [StebisController::class, 'edit'])->name('stebis.edit');

    Route::resource('/payments', PaymentController::class);
    Route::resource('/announcements', AnnouncementController::class);
    Route::resource('/tahsin', TahsinController::class);

    Route::resource('kelas', KelasController::class);
    Route::get('/admin/kelas', [KelasController::class, 'adminIndex'])->name('admin.kelas.index');;
    Route::post('admin/kelas', [KelasController::class, 'kelasFilter'])->name('kelas.filter');
    Route::get('/kelas/daftar/{id}', [KelasController::class, 'register']);;

    Route::post('/daftar/tahfiz', [KelasController::class, 'daftarTahfiz'])->name('daftar.tahfiz');
    Route::get('admin/kelas/detail/{id}', [KelasController::class, 'detailKelas'])->name('kelas.detail');
    Route::get('/kelas/detail/{id}', [KelasController::class, 'detail'])->name('kelas.detail');

    Route::get('/export-kelas/{id}', [ExportController::class, 'exportExcel'])->name('kelas.export');
    Route::post('/import-kelas', [ImportController::class, 'importExcel'])->name('kelas.import');
    Route::get('/export-kelas/lughoh/{id}', [ExportController::class, 'exportLughoh'])->name('kelas.export.lughoh');
    Route::post('/import-kelas/lughoh', [ImportController::class, 'importLughoh'])->name('kelas.import.lughoh');
    Route::post('/import-result', [ImportController::class, 'importResult'])->name('import.result');
    Route::get('/export-user', [ExportController::class, 'exportUser'])->name('user.export');
    Route::get('/export-payments', [ExportController::class, 'exportPayment'])->name('payments.export');
    Route::post('/import-payments', [ImportController::class, 'importPayment'])->name('payments.import');
    Route::get('/export-kelas-all', [ExportController::class, 'exportKelasAll'])->name('kelas.export.all');
    Route::get('/export-kelas/{id}/{batch}/{gelombang}', [ExportController::class, 'exportKelas'])->name('kelas.export.filter');

    Route::post('/create-invoice', [PaymentController::class, 'createInvoice'])->name('create.invoice');
});

Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/regencies/{provinceId}', [LocationController::class, 'getRegencies']);
Route::get('/districts/{regencyId}', [LocationController::class, 'getDistricts']);

Route::get('/get-angkatan/{programId}', [ProgramController::class, 'getAngkatan']);
Route::get('/get-gelombang/{batchId}', [ProgramController::class, 'getGelombang']);

Route::get('/pengumuman', [KelasController::class, 'pengumumanIndex']);
Route::get('/pengumuman/{program}', [KelasController::class, 'pengumuman']);
Route::get('/search', [KelasController::class, 'search'])->name('search.results');
Route::post('/webhook', [PaymentController::class, 'webhook']);
