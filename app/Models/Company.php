<?php

namespace App\Models;

use App\Models\Scopes\CompanyDetailScope;
use App\Models\Scopes\JobDetailScope;
use App\Traits\Searchable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use CrudTrait, HasFactory, Searchable;

    protected static function booted()
    {
        static::addGlobalScope(new CompanyDetailScope());
    }

    public function scopePublished($query, $value = true)
    {
        return $query->whereStatus($value);
    }

    public function incubator()
    {
        return $this->belongsTo(Incubator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function plan()
    {
        return $this->belongsTo(CompanyPlan::class)->whereStatus(1);
    }

    function plans()
    {
        return $this->hasMany(CompanyPlan::class);
    }

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
