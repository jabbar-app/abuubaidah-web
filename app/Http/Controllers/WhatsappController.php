<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    public $key = '6b2be15d876d75abbb23251d1b637a1c24e4e9f4d519934f';

    public function index()
    {
        return view('admin.whatsapp');
    }

    public function sendWhatsapp(Request $request)
    {
        $message = "Halo $request->name, ini pesan kamu ya $request->message.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->withOptions([
            'debug' => false,
            'connect_timeout' => false,
            'timeout' => false,
            'verify' => false,
        ])->post('http://116.203.191.58/api/send_message', [
            'phone_no' => $request->phone,
            'message' => $message,
            'key' => $this->key,
            'skip_link' => true
        ]);

        if ($response->successful()) {
            return 'Pesan berhasil dikirim';
        }

        return 'Gagal';
    }

    public function waPayment(Payment $payment)
    {
        $message = "Ma'had Abu Ubaidah bin Al Jarrah\n";
        $message .= "Assalamu'alaikum Warahmatullahi Wabarakatuh\n\n";
        $message .= "-----------------------------\n";
        $message .= "                 I  N  V  O  I  C  E\n";
        $message .= "-----------------------------\n\n";
        $message .= "Berikut Rincian Pendaftaran\n\n";
        $message .= "No Invoice: {$payment->external_id}\n";
        $message .= "Nama: {$payment->payer_name}\n";
        $message .= "Jenis Kelamin: {$payment->user->gender}\n";
        $message .= "Email: {$payment->payer_email}\n\n";
        $message .= "Rincian Pembayaran:\n";
        $message .= "{$payment->description}\n";
        $message .= "Nominal Tagihan: Rp " . number_format($payment->amount, 0, ',', '.') . "\n\n";
        $message .= "Batas Pembayaran:\n";
        $message .= "2x24 jam setelah mendapatkan pesan ini\n\n";
        $message .= "Silahkan Lakukan Pembayaran Melalui\n";
        $message .= "{$payment->invoice_url}\n";
        $message .= "-----------------------------\n";
        $message .= "NB. Jika link tidak bisa di klik, save nomor ini dan buka kembali pesan ini\n\n";
        $message .= "INI PESAN OTOMATIS\n";
        $message .= "sistem hanya menjawab sesuai ketentuan balas pesan,\n";
        $message .= "balas ya untuk menampilkan kontak Staff Support kami\n\n";
        $message .= "Jazakumullahu Khairan Katsiran\n";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->withOptions([
            'debug' => false,
            'connect_timeout' => false,
            'timeout' => false,
            'verify' => false,
        ])->post('http://116.203.191.58/api/send_message', [
            'phone_no' => $payment->user->phone,
            'message' => $message,
            'key' => $this->key,
            'skip_link' => true
        ]);

        if ($response->successful()) {
            return redirect()->route('my.transaction')->with('success', 'Silakan lakukan pembayaran!');
        }

        return redirect()->route('dashboard')->with('danger', 'Gagal!');
    }
}
