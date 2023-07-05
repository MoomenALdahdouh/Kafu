<?php

namespace App\Models;

use App\Traits\Searchable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use CrudTrait, HasFactory, Searchable;

    protected $fillable = [
        'key',
        'user_id',
        'incubator_key',
        'incubator_id',
        'name',
        'email',
        'mobile',
        'name_officer',
    ];

}
