<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment;
    protected $status;

    public function __construct(Payment $payment, $status)
    {
        $this->payment = $payment;
        $this->status = $status;
    }

    public function handle()
    {
        $key = Setting::where('key', 'whatsapp_key')->value('value');
        $message = $this->generateMessage($this->payment, $this->status);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://116.203.191.58/api/send_message', [
            'phone_no' => $this->payment->user->phone,
            'message' => $message,
            'key' => $key,
            'skip_link' => true
        ]);

        if ($response->failed()) {
            Log::error('Failed to send WhatsApp message', [
                'payment_id' => $this->payment->id,
                'status' => $this->status,
                'response' => $response->body()
            ]);
        }
    }

    protected function generateMessage(Payment $payment, $status)
    {
        switch ($status) {
            case 'PAID':
                return "#mahadabuubaidah\nPEMBAYARAN ANDA BERHASIL\n\nInvoice: {$payment->external_id}\nNama: {$payment->payer_name}\nProgram: {$payment->program->programmable->title}\n\nStatus: PEMBAYARAN PAID\nJazakumullahu khairan\n";
            case 'EXPIRED':
                return "#mahadabuubaidah\nPEMBAYARAN ANDA DITUTUP\n\nInvoice: {$payment->external_id}\nNama: {$payment->payer_name}\nProgram: {$payment->program->programmable->title}\n\nStatus: PEMBAYARAN EXPIRED\nUntuk membuka kembali pembayaran dapat mengikuti cara yang tertera pada link berikut:\nhttps://akun.abuubaidah.com/my-transaction\n\nJazakumullahu khairan\n";
            default:
                return "Ma'had Abu Ubaidah bin Al Jarrah\nAssalamu'alaikum Warahmatullahi Wabarakatuh\n\n--------------------------------------------------\nI  N  V  O  I  C  E\n--------------------------------------------------\n\nBerikut Rincian Pendaftaran\n\nNo Invoice: {$payment->external_id}\nNama: {$payment->payer_name}\nJenis Kelamin: {$payment->user->gender}\nEmail: {$payment->payer_email}\n\nRincian Pembayaran:\n{$payment->description}\nNominal Tagihan: Rp " . number_format($payment->amount, 0, ',', '.') . "\n\nBatas Pembayaran:\n2x24 jam setelah mendapatkan pesan ini\n\nSilahkan Lakukan Pembayaran Melalui\n{$payment->invoice_url}\n--------------------------------------------------\nNB. Jika link tidak bisa di klik, save nomor ini dan buka kembali pesan ini\n\nINI PESAN OTOMATIS\nsistem hanya menjawab sesuai ketentuan balas pesan,\nbalas ya untuk menampilkan kontak Staff Support kami\n\nJazakumullahu Khairan Katsiran\n";
        }
    }
}
