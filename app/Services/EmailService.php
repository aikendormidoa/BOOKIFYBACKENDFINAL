<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class EmailService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.mailgun.net/';

    public function __construct()
    {
        $this->apiKey = config('services.abstract.key');
    }

    public function validateEmail($request)
    {
        $apiKey = config('services.abstract.key');
        $email = $request->input('email');
        $url = 'https://api.mailgun.net/';
        $response = Http::get($url, [
            'api_key' => $apiKey,
            'email' => $email,
        ]);
        return $response->json();
    }
    
    public function sendConfirmation($email, $message)
    {
        try {
            \Mail::raw($message, function ($mail) use ($email) {
                $mail->to($email)
                     ->subject('Confirmation Email');
            });
            return ['status' => 'success', 'message' => 'Confirmation email sent'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}