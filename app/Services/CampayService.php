<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CampayService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        // Load credentials from .env via config
        $this->baseUrl = config('services.campay.base_url');
        $this->username = config('services.campay.username');
        $this->password = config('services.campay.password');
    }

    public function getAccessToken()
    {
        $response = Http::post($this->baseUrl . 'token/', [
            'username' => $this->username,
            'password' => $this->password
        ]);

        return $response->json()['token'] ?? null;
    }

    public function collectRequest($amount, $phoneNumber, $description = 'Bus Ticket')
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return ['success' => false, 'message' => 'Authentication failed. Check API Keys.'];
        }

        $formattedPhone = '237' . $phoneNumber;

        // CRITICAL FIX: Campay requires "Token" prefix, not "Bearer"
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $token,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'collect/', [
            'amount' => (string)$amount,
            'currency' => 'XAF',
            'from' => $formattedPhone,
            'description' => $description,
            'external_reference' => '',
        ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'reference' => $response->json()['reference']
            ];
        }

        return ['success' => false, 'message' => 'Payment request failed.'];
    }

    public function checkTransactionStatus($reference)
    {
        $token = $this->getAccessToken();

        if (!$token) return null;

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ])->get($this->baseUrl . 'transaction/' . $reference . '/');

        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }
}
