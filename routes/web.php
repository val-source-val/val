<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Resend\Resend;

Route::get('/', function () {
    return view('val');
});

Route::post('/send-number', function (Request $request) {

    $request->validate([
        'message' => 'required|string',
        'phone'   => 'required|digits:10'
    ]);

    $resend = Resend::client(env('RESEND_API_KEY'));

    $resend->emails->send([
        'from' => 'Valentine <onboarding@resend.dev>',
        'to' => ['pkrunak28@gmail.com'],
        'subject' => 'Valentine Response 💖',
        'html' => "
            <h2>She said YES ❤️</h2>
            <p><strong>Message:</strong><br>{$request->message}</p>
            <p><strong>Phone:</strong> {$request->phone}</p>
        ",
    ]);

    return response()->json(['ok' => true]);
});
