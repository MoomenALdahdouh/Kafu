<?php

namespace App\Services;

use App\Models\Job;
use App\Traits\JobTrait;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobAdminService
{

    use PlanTrait, JobTrait;


    public function updateJob(Request $request)
    {

        //dd($this->checkPlane($this->getPlan($request->company_id)));
        if ($this->checkPlane($this->getPlan($request->company_id))) {
            $requestData = $request->except(['id', '_token', '_method', '_http_referrer', '_save_action', 'plan_id']);
            //dd($request);
            $job = Job::query()->find($request->id)->update($requestData);
            if ($job) {
                $job = Job::findOrFail($request->id);
                $this->sendJobNotification($job);
                $this->sendJobEmail($job);
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
            "sender_type" => 0,//0:admin
        ];
        if ($job->status == 'Pending') {
            $data["message"] = "Your Job $job->name is Rejected you can add other Job!";
        }
        sendNotification($data);
    }

    public function sendJobEmail($job)
    {
        $email = [
            'recipient' => $job->user->email,
            'fromEmail' => "moomen.site@gmail.com",
            'fromName' => "منصة كفو",
            'sender_title' => "منصة كفو",
            'sender_email' => "moomen.site@gmail.com",
            'sender_name' => "النشر الوظيفي",
            'subject' => "تم اعتماد منشور الوظيفة من قبل المشرف",
            'path' => route('job.index'),
        ];

        Mail::send('job_confirm', $email, function ($message) use ($email) {
            $message->to($email['recipient'])
                ->from($email['fromEmail'], $email['fromName'])
                ->subject($email['subject']);
        });
    }

}
