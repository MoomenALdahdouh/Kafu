<?php

namespace App\Services;

use App\Models\Job;
use App\Traits\JobTrait;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;

class JobService
{

    use PlanTrait, JobTrait;

    public function getAllJobs(Request $request)
    {
        return Job::published()
            ->forCompany()
            ->forIncubator(incubator_key())
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
    }

    public function storeJob(Request $request)
    {
        if ($this->checkPlane($this->isCompany($request->company_id)->plan))
            return Job::create([
                'user_id' => auth('web')->user()->id,
                'company_id' => companyId($request->company_id),
                'incubator_key' => incubator_key(),
                'plan_id' => findCompany($request->company_id)->plan->id,
                'name' => $request->name,
                'description' => $request->description,
                'salary' => $request->salary,
            ]);
        return null;
    }

}
