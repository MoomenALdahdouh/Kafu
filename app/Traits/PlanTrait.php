<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Job;
use App\Models\JobPost;

trait PlanTrait
{
    public static function checkPlane($company_id)
    {
        $company = Company::query()->find($company_id);
        $jobPost = JobPost::query()->get()->last();
        //dd($jobPost);
        if ($company->wallet >= $jobPost->budget)
            return true;
        return false;
    }

    public static function checkPlane1($active_plan)
    {
        $total_jobs_budget = Job::query()
            ->where('status', 1)
            ->where('company_id', $active_plan->company_id)
            ->where('plan_id', $active_plan->id)
            ->pluck('budget')
            ->sum();
        //dd( $total_jobs_budget);
        if ($active_plan->budget > $total_jobs_budget && $active_plan->days > 0)
            return true;
        return false;
    }

    public static function getWallet()
    {
        if (auth()->user()->can('company')) {
            return auth()->user()->company->wallet;
        }
        return null;
    }

    public static function getWallet1()
    {
        if (auth()->user()->can('company')) {
            $plan = getCompany()->plans->where('status', 1)->first();
            $total_jobs_budget = Job::published()
                ->where('company_id', $plan->company_id)
                ->where('plan_id', $plan->id)
                ->pluck('budget')
                ->sum();
            if ($plan->budget - $total_jobs_budget > 0)
                return $plan->budget - $total_jobs_budget;
            else if ($plan->budget - $total_jobs_budget < !0)
                return $plan->budget - $total_jobs_budget;

        }
        return null;
    }
}
