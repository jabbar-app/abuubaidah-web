<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasTerdaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Seleksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        // Configuration::setXenditKey(config('xendit.secret_key'));
        Configuration::setXenditKey(config('xendit.test_key'));

        // Instansiasi InvoiceApi
        $this->invoiceApi = new InvoiceApi();
    }

    public function index()
    {
        return view('admin.payments.index', [
            'payments' => Payment::with('program.user')->orderBy('created_at', 'desc')->get(),
        ]);
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
            if ($request->method == 'Offline') {
                Payment::create([
                    'program_id' => $request->program_id,
                    'kelas_id' => $request->kelas_id,
                    'external_id' => 'off_' . time(),
                    'user_id' => $user->id,
                    'payer_name' => $user->name,
                    'payer_email' => $user->email,
                    'description' => 'Pembayaran untuk #' . $program->programmable->title,
                    'amount' => $request->amount,
                    'invoice_url' => '#',
                    'status' => $request->status,
                    'note' => 'Data di-buat oleh: ' . Auth::user()->name,
                ]);
            } else {
                $create_invoice_request = new CreateInvoiceRequest([
                    'external_id' => 'INV_' . time(),
                    'payer_id' => $user->id,
                    'payer_name' => $user->name,
                    'payer_email' => $user->email,
                    'description' => 'Pembayaran untuk #' . $program->programmable->title,
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
        try {
            if ($request->method == 'Offline') {
                $payment->update([
                    'method' => $request->method,
                    //   'amount' => $request->amount,
                    'external_id' => 'off_' . time(),
                    'status' => $request->status,
                    'invoice_url' => '#',
                    'note' => 'Data di-edit oleh: ' . Auth::user()->name,
                ]);
            } else {
                $payment->update([
                    'method' => $request->method,
                    //   'amount' => $request->amount,
                    'status' => $request->status,
                    'note' => 'Data di-edit oleh: ' . Auth::user()->name,
                ]);
            }
            return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
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
        $user = User::where('id', $request->user_id)->first();
        $program = Program::where('id', $request->program_id)->first();

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'INV_' . time(),
            'payer_id' => $user->id,
            'payer_name' => $user->name,
            'payer_email' => $user->email,
            'description' => 'Pembayaran untuk #' . $program->programmable->title,
            'amount' => $request->amount,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'reminder_time' => 1,
        ]);

        dd($program);

        try {
            $result = $this->invoiceApi->createInvoice($create_invoice_request);

            // Create a new instance of Kelas and store the returned instance in a variable
            if ($program)
            $kelas = Kelas::create([
                'user_id' => $request->user_id,
                'program_id' => $request->program_id,
                'program' => $program->programmable->title,
                'batch' => $program->programmable->batch,
                'level' => $request->level,
                'class' => $request->class,
                'room' => $request->room,
                'score' => $request->score,
                'lecturer' => $request->lecturer,
                'session' => json_encode($request->session),
                'status' => 'Menunggu Update',
            ]);

            Payment::create([
                'program_id' => $request->program_id,
                'kelas_id' => $kelas->id, // Use the ID from the Kelas instance
                'external_id' => $create_invoice_request['external_id'],
                'user_id' => $user->id,
                'payer_name' => $user->name,
                'payer_email' => $user->email,
                'description' => $create_invoice_request['description'],
                'amount' => $create_invoice_request['amount'],
                'payment_type' => $request->type,
                'invoice_url' => $result->getInvoiceUrl(),
                'status' => 'PENDING',
            ]);


            // Redirect ke URL invoice untuk proses pembayaran
            // return redirect()->to($result->getInvoiceUrl());
            if (Auth::user()->hasRole('Super Admin')) {
                return redirect()->route('admin.kelas.index')->with('success', 'Data berhasil ditambah!');
            } else {
                return redirect()->route('my.transaction');
            }
        } catch (XenditSdkException $e) {
            // Menangani eksepsi dan menampilkan pesan kesalahan
            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }

    public function createInvoiceSelection(Request $request)
    {
        // dd($request);
        $user = Auth::user();
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'INV_' . time(),
            'payer_id' => $user->id,
            'payer_name' => $user->name,
            'payer_email' => $user->email,
            'description' => 'Pembayaran untuk #' . $request->program_title,
            'amount' => $request->amount,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'reminder_time' => 1,
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
            ]);

            //   Seleksi::create([
            //     'external_id' => $create_invoice_request['external_id'],
            //     'user_id' => $user->id,
            //     'user_name' => $user->name,
            //     'program_title' => $request->program_title,
            //     'batch' => $request->batch,
            //     'status_pembayaran' => 'PENDING',
            //   ]);

            // Simpan detail pembayaran ke database
            Payment::create([
                'external_id' => $create_invoice_request['external_id'],
                'payer_id' => $user->id,
                'payer_name' => $user->name,
                'payer_email' => $user->email,
                'description' => $create_invoice_request['description'],
                'amount' => $create_invoice_request['amount'],
                'invoice_url' => $result->getInvoiceUrl(),
                'status' => 'PENDING',
            ]);

            // Redirect ke URL invoice untuk proses pembayaran
            // return redirect()->to($result->getInvoiceUrl());
            return redirect()->route('payment.status');
        } catch (XenditSdkException $e) {
            // Menangani eksepsi dan menampilkan pesan kesalahan
            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }

    public function regenerateInvoice($externalId)
    {
        // Cari pembayaran yang expired berdasarkan external_id
        $payment = Payment::where('external_id', $externalId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        // Regenerate invoice
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'INV_regen_' . time(), // Generate external ID baru
            'payer_id' => $payment->payer_id,
            'payer_name' => $payment->payer_name,
            'payer_email' => $payment->payer_email,
            'description' => $payment->description,
            'amount' => $payment->amount,
            'invoice_duration' => 172800, // Contoh: 2 hari dalam detik
            'currency' => 'IDR',
        ]);

        try {
            $result = $this->invoiceApi->createInvoice($create_invoice_request);

            // Update entri pembayaran dengan detail invoice baru
            $payment->update([
                'external_id' => $create_invoice_request['external_id'],
                'invoice_url' => $result->getInvoiceUrl(),
                'status' => 'PENDING',
            ]);

            // return response()->json(['message' => 'Invoice regenerated successfully.', 'invoice_url' => $result->getInvoiceUrl()]);
            return redirect()->back()->with('success', 'Berhasil! Invoice telah berhasil dibuat. Klik tombol Bayar untuk melakukan pembayaran.');
        } catch (XenditSdkException $e) {
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

        $_id = $arrRequestInput['id'] ?? null; // Applying null coalescing operator for potentially missing keys
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

        if ($_status === 'EXPIRED') {
            $payment->status = $_status;
            $payment->save();
            Log::info("Invoice expired for external ID: {$_externalId}");
        } else {
            $payment->status = $_status;
            // $payment->paid_amount = $_paidAmount; // Uncomment or modify according to your database schema
            $payment->updated_at = $_paidAt; // Uncomment or modify according to your database schema
            $payment->save();
            Log::info("Payment record updated for external ID: {$_externalId}");
        }

        return response()->json(['message' => 'Webhook processed successfully.']);
    }
}
