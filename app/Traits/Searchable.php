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
}
