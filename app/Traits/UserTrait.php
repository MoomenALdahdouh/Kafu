<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

trait UserTrait
{
    public function createUser(array $data)
    {
        $token = uniqid() . uniqid();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => $data['type'],
            'password' => Hash::make($data['password']),
            'remember_token' => $token,
        ]);

        //send email verification
        $user->assignRole($data['permission']);
        $email = [
            'recipient' => $data['email'],
            'fromEmail' => "moomen.site@gmail.com",
            'fromName' => "منصة كفو",
            'sender_title' => "منصة كفو",
            'sender_email' => "moomen.site@gmail.com",
            'sender_name' => "الدعم الفني",
            'subject' => "التحقق من البريد الالكتروني",
            'token' => $token,
        ];
        Mail::send('confirm', $email, function ($message) use ($email) {
            $message->to($email['recipient'])
                ->from($email['fromEmail'], $email['fromName'])
                ->subject($email['subject']);
        });

        return $user;
    }

    public function checkConfirmed($email)
    {
        $user = User::query()->where("email", $email)->get()->first();

        if ($user->status == 0)
            return Inertia::render('auth/account_confirm');
        else
            return true;
    }

}
