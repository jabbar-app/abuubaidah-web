<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendWhatsappNotification;

class WhatsappController extends Controller
{
    public $key;

    public function __construct()
    {
        $this->key = Setting::where('key', 'whatsapp_key')->value('value');
    }

    public function index()
    {
        return view('whatsapp.test');
    }

    public function sendWhatsapp(Request $request)
    {
        $key = Setting::where('key', 'whatsapp_key')->value('value');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://116.203.191.58/api/send_message', [
            'phone_no' => $request->phone,
            'message' => $request->message,
            'key' => $key,
            'skip_link' => true
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to send message'], 500);
        }

        return response()->json(['success' => 'Message sent successfully']);
    }


    public function editKey()
    {
        return view('admin.settings.woowa', [
            'key' => $this->key
        ]);
    }

    public function updateKey(Request $request)
    {
        // Validate the new key input
        $request->validate([
            'key' => 'required|string|max:255',
        ]);

        // Update the key in the settings table
        Setting::updateOrCreate(
            ['key' => 'whatsapp_key'],  // Where condition
            ['value' => $request->input('key')]  // Update with the new key
        );

        // Set a success message and redirect back
        return redirect()->back()->with('success', 'WhatsApp key updated successfully.');
    }

    public function waPayment(Payment $payment)
    {
        dispatch(new SendWhatsappNotification($payment, 'PENDING'));
        return redirect()->back()->with('success', 'Silakan lakukan pembayaran!');
    }

    public function waPaymentExprired(Payment $payment)
    {
        dispatch(new SendWhatsappNotification($payment, 'EXPIRED'));
        return redirect()->back()->with('success', 'Pembayaran expired.');
    }

    public function waPaymentPaid(Payment $payment)
    {
        dispatch(new SendWhatsappNotification($payment, 'PAID'));
        return redirect()->back()->with('success', 'Pembayaran berhasil!');
    }
}
