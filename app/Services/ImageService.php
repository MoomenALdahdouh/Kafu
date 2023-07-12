<?php

namespace App\Services;

class ImageService
{
    public function uploadImage($file)
    {
        $date = date('Y-m-d');
        $image_path = $file->store('/' . $date, 'public');
        $size = $file->getSize();
        $type = $file->extension();
        return [
            'image' => $image_path,
            'size' => $size,
            'type' => $type
        ];


    }
}
