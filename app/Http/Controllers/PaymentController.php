<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        try {

            // KONFIGURASI MIDTRANS
            Config::$serverKey    = config('midtrans.server_key');
            Config::$clientKey    = config('midtrans.client_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = config('midtrans.is_sanitized');
            Config::$is3ds        = config('midtrans.is_3ds');

            // PARAMETER PEMBAYARAN
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . time(),
                    'gross_amount' => (int)$request->total,
                ],
                'customer_details' => [
                    'first_name' => $request->nama,
                    'phone'      => $request->hp,
                ]
            ];

            // DAPATKAN TOKEN
            $snapToken = Snap::getSnapToken($params);

            return response()->json(['token' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
