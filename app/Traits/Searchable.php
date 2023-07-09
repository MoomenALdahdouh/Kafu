<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'LIKE', '%' . $keyword . '%');
    }

    public function scopeOrderByField($query, $field, $order)
    {
        if ($field) {
            return $query->orderBy($field, $order ?? 'asc');
        } else {
            return $query->latest();
        }
    }

    public function scopeForIncubator($query, $incubatorKey)
    {
        return $query->where('incubator_key', $incubatorKey);
    }

    public function scopeForCompany($query)
    {
        if (auth()->user()->can("company"))
            return $query->where('company_id', company()->id);
        else
           return $query;
    }
}
