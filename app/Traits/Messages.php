<?php

namespace App\Traits;

trait Messages
{
    public static function withMessage($message,$type = 'success')
    {
        return redirect()->back()->with('message', [
            'type' => $type,
            'text' => $message,
        ]);
    }
}
