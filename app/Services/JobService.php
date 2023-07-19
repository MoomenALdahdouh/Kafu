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
        return Job::forCompany()
            ->forIncubator(incubator_key())
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
    }

    public function storeJob(Request $request)
    {
        if ($this->checkPlane($this->getPlan($request->company_id))) {
            $job = Job::create([
                'user_id' => auth('web')->user()->id,
                'company_id' => companyId($request->company_id),
                'incubator_key' => incubator_key(),
                'plan_id' => $this->getPlan($request->company_id)->id,
                'name' => $request->name,
                'description' => $request->description,
                'salary' => $request->salary,
            ]);
            if ($job) {
                $this->sendJobNotification($job);
                return $job;
            }

        }
        return null;
    }

    public function sendJobNotification($job)
    {
        $data = [
            "title" => "Posted New Job",
            "message" => "The Company added new Job",
            "description" => "",
            "model" => get_class(new Job()),
            "model_id" => $job->id,
            "path" => "admin/job/$job->id/show",
            "sender" => $job->user_id,
            "receiver" => "",
            "status" => 0,
            "type" => 0,
            "sender_type" => 1,//1:admin
        ];
        sendNotification($data);
    }

}
