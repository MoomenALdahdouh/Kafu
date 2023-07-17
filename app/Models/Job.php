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

    public function scopePublished($query, $value = 1)
    {
        return $query->whereStatus($value);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 0:
                return "Pending";
            case 1;
                return "Published";
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        if (str_contains(url()->current(), 'admin'))
            return $value;
        return date('Y M d', strtotime($value)); // Customize the format as per your requirements
    }

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
        'status',
    ];
}
