<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

trait ConfirmEmail
{
    public static function confirmEmail(array $data)
    {
        $data = [
            'recipient' => $request->email,
            'fromEmail' => "smartmenu9@gmail.com",
            'fromName' => "سمارت منيو",
            'sender_title' => "سمارت منيو",
            'sender_email' => "smartmenu9@gmail.com",
            'sender_name' => "الدعم الفني",
            'subject' => "التحقق من الحساب",
            'token' => $token,
        ];
        //dd(env('MAIL_HOST'));
        Mail::send('confirm', $data, function ($message) use ($data) {
            $message->to($data['recipient'])
                ->from($data['fromEmail'], $data['fromName'])
                ->subject($data['subject']);
        });
    }
}
