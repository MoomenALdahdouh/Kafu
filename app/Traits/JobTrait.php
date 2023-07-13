<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Job;

trait JobTrait
{
    public static function isCompany($company_id)
    {
        if (auth('web')->user()->company)
            return auth('web')->user()->company;
        else
            return Company::query()->find($company_id);
    }
}
