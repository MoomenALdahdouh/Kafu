<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Job;

trait JobTrait
{
    public static function company($company_id)
    {
        if (company())
            return company();
        else
            return Company::query()->find($company_id);
    }
}
