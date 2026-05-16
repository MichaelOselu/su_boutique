<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    /*
    |--------------------------------------------------------------------------
    | GET ACCESS TOKEN
    |--------------------------------------------------------------------------
    */
    public function getAccessToken()
    {
        try {
            $consumerKey = env('MPESA_CONSUMER_KEY');
            $consumerSecret = env('MPESA_CONSUMER_SECRET');

            $response = Http::withBasicAuth(
                $consumerKey,
                $consumerSecret
            )->get(
                'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            );

            if (!$response->successful()) {
                Log::error('MPESA TOKEN ERROR', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return null;
            }

            return $response['access_token'] ?? null;

        } catch (\Exception $e) {
            Log::error('MPESA TOKEN EXCEPTION', [
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STK PUSH
    |--------------------------------------------------------------------------
    */
    public function stkPush($phone, $amount, $accountReference)
    {
        try {

            // GET TOKEN
            $token = $this->getAccessToken();

            if (!$token) {
                return [
                    'success' => false,
                    'message' => 'Failed to generate access token'
                ];
            }

            // FORMAT TIME
            $timestamp = now()->format('YmdHis');

            // GENERATE PASSWORD
            $password = base64_encode(
                env('MPESA_SHORTCODE') .
                env('MPESA_PASSKEY') .
                $timestamp
            );

            // SEND STK PUSH REQUEST
            $response = Http::withToken($token)->post(
                'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
                [
                    "BusinessShortCode" => env('MPESA_SHORTCODE'),
                    "Password" => $password,
                    "Timestamp" => $timestamp,
                    "TransactionType" => "CustomerPayBillOnline",
                    "Amount" => (int) $amount,
                    "PartyA" => $phone,
                    "PartyB" => env('MPESA_SHORTCODE'),
                    "PhoneNumber" => $phone,
                    "CallBackURL" => env('MPESA_CALLBACK_URL'),
                    "AccountReference" => $accountReference,
                    "TransactionDesc" => "Order Payment"
                ]
            );

            $data = $response->json();

            // LOG RESPONSE
            Log::info('MPESA STK RESPONSE', [
                'request_phone' => $phone,
                'request_amount' => $amount,
                'response' => $data
            ]);

            return $data;

        } catch (\Exception $e) {

            Log::error('MPESA STK EXCEPTION', [
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}