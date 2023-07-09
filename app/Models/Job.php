<?php

namespace App\Models;

use App\Traits\Searchable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use CrudTrait, HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'company_id',
        'incubator_key',
        'plan_id',
        'budget',
        'name',
        'description',
        'image',
        'tags',
        'salary',
        'country_id',
    ];

    /*function companies()
    {
        return Company::query()->where('incubator_key', incubator()->id)->latest()->get();
    }*/
}
