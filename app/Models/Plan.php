<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
       //'image',
        'price',
        'days',
        'budget',
        'type',
        /*'recharge',
        'free',
        'status',
        'sort',*/
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }
}
