<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsappNotification;
use App\Models\Installment;
use App\Models\Kelas;
use App\Models\KelasTerdaftar;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Seleksi;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\Invoice;
use Xendit\XenditSdkException;

class PaymentController extends Controller
{
    protected $invoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.secret_key'));
        // Configuration::setXenditKey(config('xendit.test_key'));

        // Instansiasi InvoiceApi
        $this->invoiceApi = new InvoiceApi();
    }

    public function index(Request $request)
    {
        // Get all programs
        $programs = Program::all();

        // Initialize query
        $paymentsQuery = Payment::with(['program', 'program.programmable'])->orderBy('created_at', 'desc');

        // Initialize variables
        $batches = collect();
        $gelombangs = collect();

        // Filter by program
        if ($request->has('program_id') && $request->program_id != '') {
            $program_id = $request->program_id;
            $paymentsQuery->where('program_id', $program_id);

            // Get batches for the selected program
            $program = Program::find($program_id);
            if ($program && $program->programmable) {
                $batches = $program->programmable()->distinct()->pluck('batch');
            }
        }

        // Filter by batch
        if ($request->has('batch') && $request->batch != '') {
            $batch = $request->batch;
            $paymentsQuery->whereHasMorph('program.programmable', ['App\Models\Tahsin', 'App\Models\Tahfiz', 'App\Models\Kiba'], function ($query) use ($batch) {
                $query->where('batch', $batch);
            });

            // Get gelombangs for the selected batch
            $program = Program::find($request->program_id);
            if ($program && $program->programmable) {
                $gelombangs = $program->programmable()->where('batch', $batch)->distinct()->pluck('gelombang');
            }
        }

        // Filter by gelombang
        if ($request->has('gelombang') && $request->gelombang != '') {
            $gelombang = $request->gelombang;
            $paymentsQuery->whereHasMorph('program.programmable', ['App\Models\Tahsin', 'App\Models\Tahfiz', 'App\Models\Kiba'], function ($query) use ($gelombang) {
                $query->where('gelombang', $gelombang);
            });
        }

        // Get the filtered payments
        $payments = $paymentsQuery->get();

        return view('admin.payments.index', compact('payments', 'programs', 'batches', 'gelombangs'));
    }

    public function create()
    {
        $programs = Program::all();
        $kelas = Kelas::all();
        $users = User::all();
        return view('admin.payments.create', compact('programs', 'kelas', 'users'));
    }

    public function store(Request $request)
    {

        $user = User::where('id', $request->user_id)->first();
        $program = Program::where('id', $request->program_id)->first();

        try {
            // $existingKelas = Kelas::where('user_id', $request->user_id)
            //     ->where('program_id', $request->program_id)
            //     ->first();

            // $existingPayment = Payment::where('user_id', $request->user_id)
            //     ->where('program_id', $request->program_id)
            //     ->where('kelas_id', $request->kelas_id)
            //     ->first();

            // if ($existingKelas || $existingPayment) {
            //     // If found, redirect to the specified route
            //     return redirect()->back();
            // }
            // dd($request->all());

            if ($request->method == 'Offline') {
                $payment = Payment::create([
                    'program_id' => $request->program_id,
                    'kelas_id' => $request->kelas_id,
                    'external_id' => 'off_' . time(),
                    'user_id' => $user->id,
                    'payer_name' => $user->name,
                    'payer_email' => $user->email,
                    'description' => 'Pembayaran untuk #' . $program->programmable->title . ', Angkatan #' . $program->programmable->batch,
                    'amount' => $request->amount,
                    'invoice_url' => '#',
                    'status' => $request->status,
                    'is_new' => $request->is_new,
                    'note' => 'Data di-buat oleh: ' . Auth::user()->name,
                ]);
            } else {
                $create_invoice_request = new CreateInvoiceRequest([
                    'external_id' => 'INV_' . time(),
                    'payer_id' => $user->id,
                    'payer_name' => $user->name,
                    'payer_email' => $user->email,
                    'description' => 'Pembayaran untuk #' . $program->programmable->title . ', Angkatan #' . $program->programmable->batch,
                    'amount' => $request->amount,
                    'invoice_duration' => 172800,
                    'currency' => 'IDR',
                    'reminder_time' => 1,
                ]);
                $result = $this->invoiceApi->createInvoice($create_invoice_request);
                Payment::create([
                    'program_id' => $request->program_id,
                    'kelas_id' => $request->kelas_id,
                    'external_id' => $create_invoice_request['external_id'],
                    'user_id' => $user->id,
                    'payer_name' => $user->name,
                    'payer_email' => $user->email,
                    'description' => $create_invoice_request['description'],
                    'amount' => $create_invoice_request['amount'],
                    'invoice_url' => $result->getInvoiceUrl(),
                    'status' => 'PENDING',
                    'note' => 'Data di-buat oleh: ' . Auth::user()->name,
                ]);
            }

            if ($request->has('installments')) {
                $installments = $request->installments;

                // dd($installments);

                foreach ($installments as $installment) {
                    // Check for required keys
                    if (!isset($installment['amount']) || !isset($installment['due_date'])) {
                        // Log the error or handle it as necessary
                        continue;  // Skip this iteration if required data is missing
                    }

                    Installment::create([
                        'payment_id' => $payment->id,
                        'amount' => $installment['amount'],
                        'due_date' => $installment['due_date'],
                        'status' => 'PENDING',  // assuming you always want to set this by default
                    ]);
                }
            }

            return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
        } catch (XenditSdkException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $programs = Program::all();
        $kelas = Kelas::all();
        $users = User::all();
        return view('admin.payments.edit', compact('payment', 'programs', 'kelas', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        if ($request->note == '') {
            $note = ' Data di-edit oleh: ' . Auth::user()->name;
        } else {
            $note = $request->note;
        }
        try {
            if ($request->method == 'Offline') {
                $payment->update([
                    'method' => $request->method,
                    'amount' => $request->amount,
                    'external_id' => 'off_' . time(),
                    'status' => $request->status,
                    'invoice_url' => '#',
                    'note' => $note,
                ]);

                if ($request->has('installments')) {
                    // Delete existing installments
                    $payment->installments()->delete();

                    // Add new installments
                    $installments = $request->installments;
                    foreach ($installments as $installment) {
                        Installment::create([
                            'payment_id' => $payment->id,
                            'amount' => $installment['amount'],
                            'due_date' => $installment['due_date'],
                            'status' => 'PENDING',
                        ]);
                    }
                }
            } else {
                $payment->update([
                    'method' => $request->method,
                    'amount' => $request->amount,
                    'status' => $request->status,
                    'note' => $note,
                ]);
            }

            if ($request->has('installments')) {
                $installments = Installment::where('payment_id', $payment->id)->get();
                foreach ($installments as $index => $installment) {
                    // Check if the index exists in the request array to avoid errors
                    if (isset($request->installments[$index])) {
                        $installmentData = $request->installments[$index];
                        // Check if 'status' is set for the current index
                        if (isset($installmentData['status'])) {
                            $installment->update([
                                'status' => $installmentData['status']
                            ]);
                        }
                    }
                }
            }


            return redirect()->back()->with('success', 'Payment updated successfully.');
        } catch (XenditSdkException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Invoice berhasil dihapus.');
    }

    public function createInvoice(Request $request)
    {
        // dd($request->all());
        $user = User::find($request->user_id);
        $program = Program::find($request->program_id);
        $step = $request->step ?? 'Pendaftaran Baru';
        $isAdmin = $request->fromAdmin ?? false;

        $existingKelas = Kelas::where('user_id', $request->user_id)
            ->where('program_id', $request->program_id)
            ->where('status', 'Menunggu Update')
            ->first();

        $existingPayment = Payment::where('user_id', $request->user_id)
            ->where('program_id', $request->program_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('amount', $request->amount)
            ->first();

        if (($existingKelas || $existingPayment) && !$isAdmin) {
            return redirect()->route('my.program');
        } else {
            if ($step == 'Daftar Ulang') {
                $kelas = Kelas::where('user_id', $request->user_id)->where('program_id', $request->program_id)->where('status', 'Daftar Ulang')->first();
                $kelas->status = 'Menunggu Update';
                $kelas->save();

                if ($kelas->program->programmable_type == 'App\Models\Fai' || $kelas->program->programmable_type == 'App\Models\Stebis') {
                    $isRegisteredLughoh = Kelas::where('user_id', $request->user_id)->whereHas('program', function ($query) {
                        $query->where('programmable_type', 'App\Models\Lughoh');
                    })->first();
                    if (empty($isRegisteredLughoh)) {
                        $lughoh = Program::where('programmable_type', 'App\Models\Lughoh')->where('status', 1)->first();
                        Kelas::create([
                            'user_id' => $request->user_id,
                            'program_id' => $lughoh->id,
                            'title' => $lughoh->programmable->title,
                            'batch' => $lughoh->programmable->batch,
                            'level' => '',
                            'class' => '',
                            'room' => '',
                            'score' => '',
                            'lecturer' => '',
                            'session' => '',
                            'status' => 'Menunggu Update',
                            'is_new' => 1,
                        ]);
                    }
                }
            } else {
                $kelas = Kelas::create([
                    'user_id' => $request->user_id,
                    'program_id' => $request->program_id,
                    'title' => $program->programmable->title,
                    'batch' => $program->programmable->batch,
                    'level' => $request->level,
                    'class' => $request->class,
                    'room' => $request->room,
                    'score' => $request->score,
                    'lecturer' => $request->lecturer,
                    'session' => json_encode($request->session),
                    'status' => $request->status,
                    'is_new' => $request->is_new,
                    'nim_temp' => $request->nim,
                ]);
            }

            // Pastikan nomor telepon tidak kosong
            $phoneNumber = !empty($user->phone) ? (string)$user->phone : '0000000000'; // Gunakan nomor default jika kosong

            try {
                $create_invoice_request = new CreateInvoiceRequest([
                    'external_id' => 'INV_' . time(),
                    'amount' => $request->amount,
                    'payer_email' => $user->email,
                    'description' => 'Pembayaran untuk #' . $program->programmable->title . ' Angkatan #' . $program->programmable->batch . ' Jenis Pembayaran #' . $step,
                    'invoice_duration' => 172800,
                    'currency' => 'IDR',
                    'reminder_time' => 1,
                    'should_send_email' => true,
                    'customer' => [
                        'given_names' => $user->name,
                        'email' => $user->email,
                        'mobile_number' => $phoneNumber, // Pastikan nomor telepon dikonversi menjadi string dan tidak kosong
                    ],
                    'customer_notification_preference' => [
                        'invoice_created' => ['email'],
                        'invoice_reminder' => ['email'],
                        'invoice_paid' => ['email'],
                        'invoice_expired' => ['email'],
                    ],
                    'items' => [
                        [
                            'name' => 'Pendaftaran ' . $program->programmable->title,
                            'quantity' => 1,
                            'price' => $request->amount
                        ]
                    ]
                ]);

                $result = $this->invoiceApi->createInvoice($create_invoice_request);

                $payment = Payment::create([
                    'program_id' => $request->program_id,
                    'kelas_id' => $kelas->id,
                    'external_id' => $create_invoice_request->getExternalId(),
                    'user_id' => $user->id,
                    'payer_name' => $user->name,
                    'payer_email' => $user->email,
                    'description' => $create_invoice_request->getDescription(),
                    'type' => $step,
                    'amount' => $create_invoice_request->getAmount(),
                    'method' => 'Xendit',
                    'invoice_url' => $result->getInvoiceUrl(),
                    'status' => 'PENDING',
                ]);

                if (Auth::user()->hasRole('Super Admin')) {
                    return redirect()->route('admin.kelas.index')->with('success', 'Data berhasil ditambah!');
                } else {
                    return redirect()->route('wa.payment', $payment);
                }
            } catch (XenditSdkException $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'full_error' => $e->getFullError(),
                ], 500);
            }
        }
    }

    public function createInvoiceSelection(Request $request)
    {
        $user = Auth::user();

        // Pastikan nomor telepon tidak kosong
        $phoneNumber = !empty($user->phone) ? (string)$user->phone : '0000000000';

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'INV_' . time(),
            'amount' => $request->amount,
            'payer_email' => $user->email,
            'description' => 'Pembayaran untuk #' . $request->program_title,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'reminder_time' => 1,
            'should_send_email' => true,
            'customer' => [
                'given_names' => $user->name,
                'email' => $user->email,
                'mobile_number' => $phoneNumber,
            ],
            'customer_notification_preference' => [
                'invoice_created' => ['email'],
                'invoice_reminder' => ['email'],
                'invoice_paid' => ['email'],
                'invoice_expired' => ['email'],
            ],
            'items' => [
                [
                    'name' => 'Pendaftaran ' . $request->program_title,
                    'quantity' => 1,
                    'price' => $request->amount
                ]
            ]
        ]);

        try {
            $result = $this->invoiceApi->createInvoice($create_invoice_request);

            Kelas::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'program_batch' => $request->program_batch,
                'program_title' => $request->program_title,
                'level' => $request->program_title,
                'session' => json_encode($request->session),
                'class' => "",
                'class_type' => $request->class_type,
                'score' => 0,
                'lecturer_name' => "",
                'status' => 'Menunggu Update',
                'is_new' => $request->is_new,
            ]);

            Payment::create([
                'external_id' => $create_invoice_request['external_id'],
                'payer_id' => $user->id,
                'payer_name' => $user->name,
                'payer_email' => $user->email,
                'description' => $create_invoice_request['description'],
                // 'type' => $request->type,
                'amount' => $create_invoice_request['amount'],
                'invoice_url' => $result->getInvoiceUrl(),
                'status' => 'PENDING',
            ]);

            return redirect()->route('payment.status');
        } catch (XenditSdkException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }

    public function regenerateInvoice($externalId)
    {
        $payment = Payment::where('external_id', $externalId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        $user = User::find($payment->payer_id);
        $phoneNumber = !empty($user->phone) ? (string)$user->phone : '0000000000';

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'INV_regen_' . time(),
            'amount' => $payment->amount,
            'payer_email' => $payment->payer_email,
            'description' => $payment->description,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'should_send_email' => true,
            'customer' => [
                'given_names' => $payment->payer_name,
                'email' => $payment->payer_email,
                'mobile_number' => $phoneNumber,
            ],
            'customer_notification_preference' => [
                'invoice_created' => ['email'],
                'invoice_reminder' => ['email'],
                'invoice_paid' => ['email'],
                'invoice_expired' => ['email'],
            ],
            'items' => [
                [
                    'name' => 'Pendaftaran ' . $payment->description,
                    'quantity' => 1,
                    'price' => $payment->amount
                ]
            ]
        ]);

        try {
            Log::info('Sending request to Xendit', ['request' => $create_invoice_request]);

            $result = $this->invoiceApi->createInvoice($create_invoice_request);

            Log::info('Received response from Xendit', ['response' => $result]);

            // Access properties correctly based on the structure
            $external_id = $create_invoice_request['external_id']; // $result->id;
            $invoice_url = $result->getInvoiceUrl(); // $result->invoice_url;

            // Update payment record
            $payment->update([
                'external_id' => $external_id,
                'invoice_url' => $invoice_url,
                'status' => 'PENDING',
            ]);

            return redirect()->route('wa.payment', $payment);
        } catch (XenditSdkException $e) {
            Log::error('Error creating invoice with Xendit', [
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ]);

            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }




    public function webhook()
    {
        $xenditXCallbackToken = 'A0E72Q8un23GyGx6k88iWVQsjwxCr54bCMXQXs1yUi5z9WRV';

        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders['x-callback-token']) ? $reqHeaders['x-callback-token'] : "";

        $rawRequestInput = file_get_contents("php://input");
        $arrRequestInput = json_decode($rawRequestInput, true);
        Log::info($arrRequestInput);

        $_id = $arrRequestInput['id'] ?? null;
        $_externalId = $arrRequestInput['external_id'] ?? null;
        $_userId = $arrRequestInput['user_id'] ?? null;
        $_status = $arrRequestInput['status'] ?? null;
        $_paidAmount = $arrRequestInput['paid_amount'] ?? null;
        $_paidAt = $arrRequestInput['paid_at'] ?? null;
        $_paymentChannel = $arrRequestInput['payment_channel'] ?? null;
        $_paymentDestination = $arrRequestInput['payment_destination'] ?? null;

        $payment = Payment::where('external_id', $_externalId)->first();
        if (!$payment) {
            return response()->json(['message' => 'Payment record not found.'], 404);
        }

        if ($_status === 'EXPIRED' && $payment->status != 'PAID') {
            $payment->status = $_status;
            $payment->save();
            Log::info("Invoice expired for external ID: {$_externalId}");
            dispatch(new SendWhatsappNotification($payment, 'EXPIRED'));
            return response()->json(['message' => 'Invoice expired.']);
        } else {
            $payment->status = $_status;
            $payment->updated_at = $_paidAt;
            $payment->save();
            Log::info("Payment record updated for external ID: {$_externalId}");
            dispatch(new SendWhatsappNotification($payment, 'PAID'));
            return response()->json(['message' => 'Payment record updated.']);
        }
    }


    public function tahsin(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Tahsin', 'admin.payments.tahsin', $request);
    }

    public function bilhaq(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Bilhaq', 'admin.payments.bilhaq', $request);
    }

    public function tahfiz(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Tahfiz', 'admin.payments.tahfiz', $request);
    }

    public function lughoh(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Lughoh', 'admin.payments.lughoh', $request);
    }

    public function kiba(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Kiba', 'admin.payments.kiba', $request);
    }

    public function fai(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Fai', 'admin.payments.fai', $request);
    }

    public function stebis(Request $request)
    {
        return $this->getPaymentsByProgram('App\Models\Stebis', 'admin.payments.stebis', $request);
    }

    private function getPaymentsByProgram($programmableType, $viewName, Request $request)
    {
        $batch = $request->input('batch');

        $programsQuery = Program::where('programmable_type', $programmableType)
            ->when($batch, function ($query, $batch) {
                return $query->whereHas('programmable', function ($q) use ($batch) {
                    $q->where('batch', $batch);
                });
            });

        $batches = Program::where('programmable_type', $programmableType)
            ->with('programmable')
            ->get()
            ->pluck('programmable.batch')
            ->unique()
            ->values();

        $programs = $programsQuery->get();

        $allPayments = collect();

        foreach ($programs as $program) {
            $payments = Payment::where('program_id', $program->id)->get();
            $allPayments = $allPayments->merge($payments);
        }

        return view($viewName, [
            'payments' => $allPayments,
            'batches' => $batches,
            'selectedBatch' => $batch
        ]);
    }
}
