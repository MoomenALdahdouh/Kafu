<?php

namespace App\Models;

use App\Traits\Searchable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incubator extends Model
{
    use CrudTrait, HasFactory, Searchable;

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

    function companies()
   {
       return $this->hasMany(Company::class);
   }
}
