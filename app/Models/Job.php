<?php

namespace App\Models;

use App\Models\Scopes\JobDetailScope;
use App\Traits\Searchable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use CrudTrait, HasFactory, Searchable;

    protected static function booted()
    {
        static::addGlobalScope(new JobDetailScope());
    }

    public function scopePublished($query, $value = true)
    {
        return $query->whereStatus($value);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y M d', strtotime($value)); // Customize the format as per your requirements
    }

    protected $fillable = [
        'user_id',
        'company_id',
        'company_id',
        'incubator_key',
        'plan_id',
        'budget',
        'name',
        'description',
        'image',
        'tags',
        'salary',
    ];
}
