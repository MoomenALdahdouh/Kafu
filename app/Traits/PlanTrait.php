<?php

namespace App\Traits;

use App\Models\CompanyPlan;
use App\Models\Job;

trait PlanTrait
{
    public static function checkPlane($active_plan)
    {
        $total_jobs_budget = Job::query()
            ->where('company_id', $active_plan->company_id)
            ->where('plan_id', $active_plan->id)
            ->pluck('budget')
            ->sum();
        if ($active_plan->budget > $total_jobs_budget && $active_plan->days > 0)
            return true;
        return false;
    }

    public static function getWallet($company)
    {
        if (auth()->user()->can('company')) {
            $plan = getCompany()->plans->where('status',1)->first();
            $total_jobs_budget = Job::query()
                ->where('company_id', $plan->company_id)
                ->where('plan_id', $plan->id)
                ->pluck('budget')
                ->sum();
            if ($plan->budget - $total_jobs_budget > 0)
                return $plan->budget - $total_jobs_budget;
        }
        return null;
    }
}
