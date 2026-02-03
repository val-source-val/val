<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('val'); // 👈 matches val.blade.php
});

Route::post('/send-number', function (Request $request) {

    $request->validate([
        'phone' => 'required|digits:10'
    ]);

    Mail::raw(
        "She said YES ❤️\nMobile Number: " . $request->phone,
        function ($message) {
            $message->to('letsgivechance@gmail.com')
                    ->subject('Valentine Response');
        }
    );

    return response()->json(['ok' => true]);
});
