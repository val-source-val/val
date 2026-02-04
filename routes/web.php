<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('val');
});

Route::post('/send-number', function (Request $request) {

    $request->validate([
        'message' => 'required|string',
        'phone'   => 'required|digits:10'
    ]);

    Mail::raw(
        "She said YES ❤️\n\nMessage:\n{$request->message}\n\nPhone: {$request->phone}",
        function ($mail) {
            $mail->to('pkrunak28@gmail.com')
                 ->subject('Valentine Response 💖');
        }
    );

    return response()->json(['ok' => true]);
});
