<?php

namespace App\Services;

use App\Models\Job;
use App\Traits\JobTrait;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;

class JobAdminService
{

    use PlanTrait, JobTrait;


    public function updateJob(Request $request)
    {
        if ($this->checkPlane($this->getPlan($request->company_id))) {
            $requestData = $request->except(['id', '_token', '_method', '_http_referrer', '_save_action', 'plan_id']);
            // dd($requestData);
            $job = Job::query()->find($request->id)->update($requestData);
            if ($job) {
                $job = Job::findOrFail($request->id);
                $this->sendJobNotification($job);
                return $job;
            }

        }
        return null;
    }

    public function sendJobNotification($job)
    {
       // dd(auth("backpack")->user());
        $data = [
            "title" => "Admin Approved Your Job",
            "message" => "Your Job $job->name is Published now!",
            "description" => "",
            "model" => get_class(new Job()),
            "model_id" => $job->id,
            "path" => "",
            "sender" => auth("backpack")->user()->id,
            "receiver" => $job->user_id,
            "status" => 0,
            "type" => 1,//not path
        ];
        if ($job->status == 'Pending') {
            $data["message"] = "Your Job $job->name is Rejected you can add other Job!";
        }
        sendNotification($data);
    }

}
