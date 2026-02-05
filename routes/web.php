<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('val');
});

Route::post('/send-number', function (Request $request) {

    $request->validate([
        'message' => 'required|string',
        'phone'   => 'required|digits:10'
    ]);

    $response = Http::withToken(env('RESEND_API_KEY'))
        ->post('https://api.resend.com/emails', [
            'from' => 'Valentine <onboarding@resend.dev>',
            'to' => ['pkrunak28@gmail.com'],
            'subject' => 'Valentine Response 💖',
            'html' => "
                <h2>She said YES ❤️</h2>
                <p><strong>Message:</strong><br>{$request->message}</p>
                <p><strong>Phone:</strong> {$request->phone}</p>
            ",
        ]);

    if ($response->failed()) {
        return response()->json([
            'status' => 'error',
            'resend_response' => $response->json()
        ], 500);
    }

    return response()->json([
        'status' => 'sent',
        'resend_response' => $response->json()
    ]);
});
