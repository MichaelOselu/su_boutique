<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Log;


class MpesaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STK PUSH REQUEST
    |--------------------------------------------------------------------------
    */
    public function stk(Request $request, $orderId)
    {
        try {

            $request->validate([
                'phone' => 'required'
            ]);

            $order = Order::findOrFail($orderId);

            $mpesa = new MpesaService();

            // FORMAT PHONE (important fix)
            $phone = $this->formatPhone($request->phone);

            $response = $mpesa->stkPush(
                $phone,
                $order->total,
                "ORDER-" . $order->id
            );

            // LOG RESPONSE (VERY IMPORTANT FOR DEBUGGING)
            Log::info('M-PESA STK RESPONSE', $response);

            /*
            |-----------------------------------------
            | CHECK IF REQUEST WAS SUCCESSFUL
            |-----------------------------------------
            */
            if (!isset($response['ResponseCode']) || $response['ResponseCode'] != "0") {
                return response()->json([
                    'success' => false,
                    'message' => $response['errorMessage'] ?? 'STK request failed',
                    'data' => $response
                ], 400);
            }

            /*
            |-----------------------------------------
            | SAVE PAYMENT RECORD
            |-----------------------------------------
            */
            Payment::create([
                'order_id' => $order->id,
                'phone' => $phone,
                'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
                'merchant_request_id' => $response['MerchantRequestID'] ?? null,
                'amount' => $order->total,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'STK Push sent successfully',
                'data' => $response
            ]);

        } catch (\Exception $e) {

            Log::error('M-PESA STK ERROR: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Server error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CALLBACK
    |--------------------------------------------------------------------------
    */
    public function callback(Request $request)
    {
        Log::info('M-PESA CALLBACK RECEIVED', $request->all());

        $data = $request->all();

        if (!isset($data['Body']['stkCallback'])) {
            return response()->json(['error' => 'Invalid callback']);
        }

        $callback = $data['Body']['stkCallback'];

        $checkoutRequestID = $callback['CheckoutRequestID'] ?? null;
        $resultCode = $callback['ResultCode'] ?? null;

        $payment = Payment::where('checkout_request_id', $checkoutRequestID)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found']);
        }

        if ($resultCode != 0) {

            $payment->update(['status' => 'failed']);

            return response()->json(['ok' => true]);
        }

        $metadata = $callback['CallbackMetadata']['Item'] ?? [];

        $receipt = null;

        foreach ($metadata as $item) {
            if ($item['Name'] === 'MpesaReceiptNumber') {
                $receipt = $item['Value'];
            }
        }

        $payment->update([
            'status' => 'paid',
            'receipt_number' => $receipt
        ]);

        $payment->order?->update([
            'status' => 'paid'
        ]);

        return response()->json(['ok' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | PHONE FORMAT HELPER
    |--------------------------------------------------------------------------
    */
    private function formatPhone($phone)
    {
        // convert 07xxxxxxxx → 2547xxxxxxxx
        if (str_starts_with($phone, '0')) {
            return '254' . substr($phone, 1);
        }

        return $phone;
    }
}
