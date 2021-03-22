<?php

namespace App\Http\Controllers;

use Mail;

class EmailController extends Controller
{
    public function sendEmail() {
        $data['title'] = "email";
        Mail::send('email', $data, function ($message) {
            $message
                ->to('donlijobs@gmail.com', 'Receiver Name')
                ->subject('first email from laravel');
        });

        return view('email');
    }
}
