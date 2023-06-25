<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incubator extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'user_id',
        'logo',
        'image',
        'name_officer',
        'projects',
        'country_code_id',
        'country_id',
        'message',
        'password',
        'condition',
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
