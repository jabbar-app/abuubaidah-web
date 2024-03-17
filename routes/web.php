<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BilhaqController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KibaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LughohController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StebisController;
use App\Http\Controllers\TahfizController;
use App\Http\Controllers\TahsinController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function() {
    return redirect()->route('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('student.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-program', [DashboardController::class, 'myProgram'])->name('my.program');
    Route::get('/my-transaction', [DashboardController::class, 'myTransaction'])->name('my.transaction');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('kelas', KelasController::class)->middleware('auth');
Route::get('/admin/kelas', [KelasController::class, 'adminIndex'])->name('admin.kelas.index');
Route::get('/kelas/create/{id}', [KelasController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::post('/create-invoice', [PaymentController::class,'createInvoice'])->name('create.invoice');
    Route::get('/webhook', [PaymentController::class, 'webhook']);
});
Route::controller(PaymentController::class)->group(function () {
    Route::post('/create-invoice-selection', 'createInvoiceSelection')->name('program.selection');
    Route::post('/invoice/regenerate/{externalId}', 'regenerateInvoice')->name('invoice.regenerate');
    Route::delete('/invoice/delete/{id}', 'destroy')->name('invoice.destroy');
});
Route::resource('payments', PaymentController::class);

Route::resource('/users', UserController::class)->middleware('auth');

Route::resource('/programs', ProgramController::class)->middleware('auth');
Route::resource('/tahsins', TahsinController::class)->middleware('auth');
Route::resource('/tahfizs', TahfizController::class)->middleware('auth');
Route::resource('/bilhaqs', BilhaqController::class)->middleware('auth');
Route::resource('/kibas', KibaController::class)->middleware('auth');
Route::resource('/lughohs', LughohController::class)->middleware('auth');
Route::resource('/fais', FaiController::class)->middleware('auth');
Route::resource('/stebis', StebisController::class)->middleware('auth');
Route::resource('/programs', ProgramController::class)->middleware('auth');
Route::resource('/payments', PaymentController::class)->middleware('auth');
Route::resource('/announcements', AnnouncementController::class)->middleware('auth');
Route::resource('/tahsin', TahsinController::class)->middleware('auth');

Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/regencies/{provinceId}', [LocationController::class, 'getRegencies']);
Route::get('/districts/{regencyId}', [LocationController::class, 'getDistricts']);
