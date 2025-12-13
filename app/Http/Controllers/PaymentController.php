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
            Config::$serverKey    = config('Midtrans.server_key');
            Config::$clientKey    = config('Midtrans.client_key');
            Config::$isProduction = config('Midtrans.is_production');
            Config::$isSanitized  = config('Midtrans.is_sanitized');
            Config::$is3ds        = config('Midtrans.is_3ds');

            // ==== BUAT ORDER ID ====
            $orderId = 'ORDER-' . time();

            // ===== UPDATE PEMBAYARAN DENGAN ORDER ID =====
            \App\Models\Pembayaran::where('id', $request->pembayaran_id)
                ->update([
                    'order_id' => $orderId
                ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
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


    public function callback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $order_id = $notif->order_id;
        $transaction_status = $notif->transaction_status;

        // CARI DATA PEMBAYARAN
        $pembayaran = \App\Models\Pembayaran::where('order_id', $order_id)->first();

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran not found'], 404);
        }

        if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
            $pembayaran->status = 'lunas';
        } else if ($transaction_status == 'pending') {
            $pembayaran->status = 'pending';
        } else {
            $pembayaran->status = 'gagal';
        }

        $pembayaran->save();

        return response()->json(['message' => 'OK'], 200);
    }


}
