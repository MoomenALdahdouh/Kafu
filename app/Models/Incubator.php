<?php

namespace App\Models;

use App\Models\Scopes\IncubatorDetailScope;
use App\Traits\Searchable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incubator extends Model
{
    use CrudTrait, HasFactory, Searchable;

    protected static function booted()
    {
        static::addGlobalScope(new IncubatorDetailScope());
    }

    public function scopePublished($query, $value = true)
    {
        return $query->whereStatus($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function companies()
    {
        return $this->hasMany(Company::class);
    }

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
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
