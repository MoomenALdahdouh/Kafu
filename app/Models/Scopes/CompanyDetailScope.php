<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyDetailScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->with('incubator:id,name', 'user:id,name'
           /* ,'plan:id,name,user_id,company_id,plan_id,description,price,days,budget'
            ,'plans:id,name,user_id,company_id,plan_id,description,price,days,budget'*/);
    }
}
