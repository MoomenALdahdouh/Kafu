<?php

namespace App\Traits;

use App\Models\Company;

trait JobTrait
{
    public function isCompany($company_id)
    {
        if ($company_id)
            return Company::query()->find($company_id);
        else
            return auth('web')->user()->company;
    }

    public function getPlan($company_id){
      return  $this->isCompany($company_id)->plans->where('status',1)->first();
    }
}
