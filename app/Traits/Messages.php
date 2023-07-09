<?php

namespace App\Traits;

trait Messages
{
    public static function withSuccessMessage($message,$type = 'success')
    {
        return redirect()->back()->with('message', [
            'type' => $type,
            'text' => $message,
        ]);
    }
}
