<?php

namespace App\Traits;

trait Messages
{
    private function withSuccessMessage($message)
    {
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => $message,
        ]);
    }
}
