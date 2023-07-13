<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'company_id',
        'name',
        'description',
        'price',
        'budget',
        'days',
        'status',
    ];

    function user(){
        return $this->hasOne(User::class);
    }

    function company(){
        return $this->hasOne(Company::class);
    }

    function plan(){
        return $this->hasOne(Plan::class);
    }
}
