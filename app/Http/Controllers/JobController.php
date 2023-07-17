<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Services\JobService;
use App\Traits\JobTrait;
use App\Traits\Messages;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    use Messages, PlanTrait, JobTrait;

    protected $jobservice;

    public function __construct(JobService $jobservice)
    {
        $this->jobservice = $jobservice;
    }

    public function index(Request $request)
    {
        $data = $this->jobservice->getAllJobs($request);
        return Inertia::render('job/index', [
            'items' => $data,
            'companies' => incubator() ? incubator()->companies : [],
            'permissions' => getUserPermissions(),
            'wallet' => $this->getWallet(),
            'notifications'=> getNotifications(auth("web")->user()->id),
        ]);
    }

    public function store(StoreJobRequest $request)
    {
        $job = $this->jobservice->storeJob($request);
        if ($job)
            return $this->withMessage('Success create job!');
        return $this->withMessage('Your Wallet is empty, Recharge your wallet!', 'error');
    }

    public function update(Job $job, UpdateJobRequest $request)
    {
        $job->update($request->all());
        return $this->withMessage('Success edit job!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return $this->withMessage('Success delete job!');
    }
}
