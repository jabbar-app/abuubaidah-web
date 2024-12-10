<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BilhaqController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FaiController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KibaController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LughohController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\MustawaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StebisController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TahfizController;
use App\Http\Controllers\TahsinController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SpamCheckController;
use App\Http\Controllers\TranscriptController;
use App\Http\Controllers\WhatsappController;
use App\Http\Middleware\CheckSiteStatus;
use App\Models\Kelas;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Student;
use App\Models\Transcript;
use App\Models\User;

Route::middleware(CheckSiteStatus::class)->group(function () {
    Route::get('/welcome', function () {

        $invoice = Payment::where('external_id', 'INV_1717388635')->first();

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        $user = User::where('id', $invoice->user_id)->first();

        return view('student.invoice', compact('invoice', 'user'));
    });

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Route::get('/dashboard', function () {
    //     return view('student.dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/spam-check', [SpamCheckController::class, 'showSpamCheck'])->name('spam.check');
    Route::get('/spam-check-redirect', [SpamCheckController::class, 'redirectToDashboard'])->name('spam.check.redirect');

    require __DIR__ . '/auth.php';

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-program', [DashboardController::class, 'myProgram'])->name('my.program');
        Route::get('/my-transaction', [DashboardController::class, 'myTransaction'])->name('my.transaction');
        Route::get('/detail-transaksi/{payment}', [StudentController::class, 'detailTransaction'])->name('detail.transaction');
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
            Route::post('admin/payment', 'paymentFilter')->name('payment.filter');
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
        Route::get('/admin/kelas', [KelasController::class, 'adminIndex'])->name('admin.kelas.index');
        Route::get('/kelas/program/tahsin', [KelasController::class, 'tahsinView'])->name('admin.kelas.tahsin');
        Route::get('/kelas/program/bilhaq', [KelasController::class, 'bilhaqView'])->name('admin.kelas.bilhaq');
        Route::get('/kelas/program/tahfiz', [KelasController::class, 'tahfizView'])->name('admin.kelas.tahfiz');
        Route::get('/kelas/program/lughoh', [KelasController::class, 'lughohView'])->name('admin.kelas.lughoh');
        Route::get('/kelas/program/kiba', [KelasController::class, 'kibaView'])->name('admin.kelas.kiba');
        Route::get('/kelas/program/bilhaq', [KelasController::class, 'bilhaqView'])->name('admin.kelas.bilhaq');
        Route::get('/kelas/program/fai', [KelasController::class, 'faiView'])->name('admin.kelas.fai');
        Route::get('/kelas/program/stebis', [KelasController::class, 'stebisView'])->name('admin.kelas.stebis');
        Route::post('admin/kelas', [KelasController::class, 'kelasFilter'])->name('kelas.filter');
        Route::get('/kelas/daftar/{id}', [KelasController::class, 'register']);
        Route::get('/daftar-bilhaq/{program}', [KelasController::class, 'daftarBilhaq'])->name('daftar.bilhaq');

        Route::post('/daftar/tahfiz', [KelasController::class, 'daftarTahfiz'])->name('daftar.tahfiz');
        Route::get('admin/kelas/detail/{id}', [KelasController::class, 'detailKelas'])->name('admin.kelas.detail');
        Route::get('/kelas/detail/{id}', [KelasController::class, 'detail'])->name('kelas.detail');

        Route::get('/export-kelas/{programmableType}/{batch?}/{gelombang?}', [ExportController::class, 'exportKelas'])->name('export.kelas');
        Route::post('/import-kelas', [ImportController::class, 'importExcel'])->name('kelas.import');
        Route::get('/export-kelas/lughoh/{id}', [ExportController::class, 'exportLughoh'])->name('kelas.export.lughoh');
        Route::post('/import-kelas/lughoh', [ImportController::class, 'importLughoh'])->name('kelas.import.lughoh');
        Route::post('/import-result', [ImportController::class, 'importResult'])->name('import.result');
        Route::get('/export-user', [ExportController::class, 'exportUser'])->name('user.export');
        Route::get('/export-payments', [ExportController::class, 'exportPayment'])->name('payments.export');
        Route::get('/export-payments/{id}/{batch}/{gelombang}', [ExportController::class, 'exportPaymentData']);
        Route::get('/export-payments/{id}/{batch}', [ExportController::class, 'exportPaymentData']);
        Route::post('/import-payments', [ImportController::class, 'importPayment'])->name('payments.import');
        Route::get('/export-kelas-all', [ExportController::class, 'exportKelasAll'])->name('kelas.export.all');
        Route::get('export/payment/tahsin/{batch?}', [ExportController::class, 'exportPaymentTahsin'])->name('export.payment.tahsin');
        Route::get('export/payment/bilhaq/{batch?}', [ExportController::class, 'exportPaymentBilhaq'])->name('export.payment.bilhaq');
        Route::get('export/payment/tahfiz/{batch?}', [ExportController::class, 'exportPaymentTahfiz'])->name('export.payment.tahfiz');
        Route::get('export/payment/lughoh/{batch?}', [ExportController::class, 'exportPaymentLughoh'])->name('export.payment.lughoh');
        Route::get('export/payment/kiba/{batch?}', [ExportController::class, 'exportPaymentKiba'])->name('export.payment.kiba');
        Route::get('export/payment/fai/{batch?}', [ExportController::class, 'exportPaymentFai'])->name('export.payment.fai');
        Route::get('export/payment/stebis/{batch?}', [ExportController::class, 'exportPaymentStebis'])->name('export.payment.stebis');

        Route::post('/create-invoice', [PaymentController::class, 'createInvoice'])->name('create.invoice');

        Route::post('/generate-nim', [StudentController::class, 'generateNIM'])->name('generate-nim');
        Route::get('/kartu-hasil-studi', [StudentController::class, 'khs'])->name('khs');

        Route::get('/generate-pdf/{id}', [PdfController::class, 'generatePdf'])->name('generatePdf');
        Route::get('/certificate-pdf/{id}', [PdfController::class, 'certificatePdf'])->name('certificatePdf');
        Route::get('/invoice/download/{externalId}', [PdfController::class, 'invoicePdf'])->name('invoice.download');
        Route::resource('courses', CourseController::class);
        Route::resource('students', StudentController::class);
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::get('/students/{id}/edit-grades', [StudentController::class, 'editGrades'])->name('edit-grades');
        Route::put('/students/{id}/assign-grades', [StudentController::class, 'updateGrades'])->name('assign-grades');

        Route::resource('transcripts', TranscriptController::class);
        Route::get('/transcripts/add', [TranscriptController::class, 'transcriptAdd'])->name('transcripts.add');
        Route::get('students/{id}/assign', [StudentController::class, 'assignCoursesForm'])->name('students.assignCoursesForm');
        Route::resource('lecturers', LecturerController::class);

        Route::get('/students/{student}/assign', [StudentController::class, 'assignCourses'])->name('students.assign');
        Route::get('/mustawa', [TranscriptController::class, 'mustawa'])->name('mustawa.index');
        Route::get('/khs/{student}', [TranscriptController::class, 'showKHS'])->name('students.khs');
        Route::get('/export/mustawa/{type}', [TranscriptController::class, 'exportMustawa'])->name('exportMustawa');
        Route::post('/import/mustawa/{type}', [TranscriptController::class, 'importMustawa'])->name('importMustawa');
        Route::get('/transcripts/{id}/edit', [TranscriptController::class, 'edit'])->name('editTranscript');
        Route::post('/transcripts/{id}/update', [TranscriptController::class, 'update'])->name('updateTranscript');
        Route::post('/transcripts/update', [TranscriptController::class, 'bulkUpdate'])->name('bulkUpdateTranscripts');
        Route::get('/lihat-transkrip/{student}', [TranscriptController::class, 'transcripts'])->name('transcripts');
        Route::post('/unduh-transkrip/{student}', [TranscriptController::class, 'downloadTranscripts'])->name('transcripts.download');


        Route::get('/mustawa/{type}/{id}/edit', [MustawaController::class, 'edit'])->name('editMustawa');
        Route::post('/mustawa/{type}/{id}/update', [MustawaController::class, 'update'])->name('updateMustawa');
    });

    Route::get('/admin/students/export', [ExportController::class, 'exportStudents'])->name('students.export');
    Route::get('/admin/students/import', [ImportController::class, 'showImportForm'])->name('admin.students.import');
    Route::post('/admin/students/import', [ImportController::class, 'importDataStudents'])->name('students.import');
    Route::post('/admin/students/synchronize', [ImportController::class, 'synchronizeStudents'])->name('students.synchronize');


    Route::get('/clear-cache', [SettingController::class, 'clearCache'])->name('clear.cache');


    Route::post('/check-nim', [KelasController::class, 'checkNim'])->name('check-nim');

    Route::get('/send-whatsapp', [WhatsappController::class, 'index'])->name('whatsapp');
    Route::post('/send-whatsapp', [WhatsappController::class, 'sendWhatsapp'])->name('whatsapp.send');
    Route::get('/send-whatsapp/{payment}', [WhatsappController::class, 'waPayment'])->name('wa.payment');
    Route::get('/send-whatsapp/{payment}/expired', [WhatsappController::class, 'waPaymentExpired'])->name('wa.payment.expired');
    Route::get('/send-whatsapp/{payment}/paid', [WhatsappController::class, 'waPaymentPaid'])->name('wa.payment.paid');
    Route::get('/update-whatsapp-key', [WhatsappController::class, 'editKey'])->name('edit.whatsapp.key');
    Route::post('/update-whatsapp-key', [WhatsappController::class, 'updateKey'])->name('update.whatsapp.key');

    Route::get('/user-pdf/{id}', [PdfController::class, 'userPdf'])->name('user.pdf');

    Route::get('/provinces', [LocationController::class, 'getProvinces']);
    Route::get('/regencies/{provinceId}', [LocationController::class, 'getRegencies']);
    Route::get('/districts/{regencyId}', [LocationController::class, 'getDistricts']);

    Route::get('/get-angkatan/{programId}', [ProgramController::class, 'getAngkatan']);
    Route::get('/get-gelombang/{batchId}', [ProgramController::class, 'getGelombang']);

    Route::get('/pengumuman', [KelasController::class, 'pengumumanIndex']);
    Route::get('/pengumuman/{program}', [KelasController::class, 'pengumuman']);
    Route::get('/search', [KelasController::class, 'search'])->name('search.results');
    Route::post('/webhook', [PaymentController::class, 'webhook']);
    Route::get('/payment', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/payment/tahsin', [PaymentController::class, 'tahsin'])->name('admin.payments.tahsin');
    Route::get('/payment/bilhaq', [PaymentController::class, 'bilhaq'])->name('admin.payments.bilhaq');
    Route::get('/payment/tahfiz', [PaymentController::class, 'tahfiz'])->name('admin.payments.tahfiz');
    Route::get('/payment/lughoh', [PaymentController::class, 'lughoh'])->name('admin.payments.lughoh');
    Route::get('/payment/kiba', [PaymentController::class, 'kiba'])->name('admin.payments.kiba');
    Route::get('/payment/bilhaq', [PaymentController::class, 'bilhaq'])->name('admin.payments.bilhaq');
    Route::get('/payment/fai', [PaymentController::class, 'fai'])->name('admin.payments.fai');
    Route::get('/payment/stebis', [PaymentController::class, 'stebis'])->name('admin.payments.stebis');

    Route::get('upload-nim', function () {
        return view('admin.upload');
    })->name('upload.form');

    Route::get('/nims/data', [ImportController::class, 'dataNims'])->name('nims.data');
    Route::post('/upload/nims', [ImportController::class, 'uploadNims'])->name('upload.nims');
    Route::delete('/nims/reset', [ImportController::class, 'resetNims'])->name('nims.reset');


    Route::get('/mobile/login', [MobileController::class, 'loginShow'])->name('mobile.login.show');
    Route::post('/mobile/login', [MobileController::class, 'login'])->name('mobile.login');
    Route::get('/mobile/register', [MobileController::class, 'registerShow'])->name('mobile.register.show');
    Route::post('/mobile/register', [MobileController::class, 'register'])->name('mobile.register');

    Route::get('check-view', function () {

        $kelas = Kelas::where('id', 2275)->first();
        $program = Program::where("id", $kelas->program_id)->first();
        // $student = Student::where('user_id', auth()->user()->id)->first();
        // $transcripts = Transcript::where('student_id', $student->id)->get();
        // return view('admin.exports.transcript', compact('student', 'transcripts'));

        return view('admin.exports.certificate', compact('kelas', 'program'));
    })->name('upload.form');
});
