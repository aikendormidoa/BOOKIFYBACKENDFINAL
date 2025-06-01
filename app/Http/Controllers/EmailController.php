<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;

class EmailController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function validateEmail(Request $request)
    {
        return response()->json($this->emailService->validateEmail($request));
    }
    
    public function sendConfirmation(Request $request)
    {
        $email = $request->input('email');
        $message = $request->input('message', 'Your booking is confirmed!');
        return response()->json($this->emailService->sendConfirmation($email, $message));
    }
}