<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Incubator;
use App\Models\Job;
use App\Models\User;
use App\Services\JobService;
use App\Traits\JobTrait;
use App\Traits\Messages;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

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
            'wallet' => $this->getWallet(getCompany()),
        ]);
    }

    public function store(StoreJobRequest $request)
    {
        if ($this->checkPlane($this->company($request->company_id)->plan)) {
            $job = Job::create([
                'user_id' => auth('web')->user()->id,
                'company_id' => companyId($request->company_id),
                'incubator_key' => incubator_key(),
                'plan_id' => findCompany($request->company_id)->plan->id,
                'name' => $request->name,
                'description' => $request->description,
                'salary' => $request->salary,
            ]);
            return $this->withMessage('Success create job!');
        }
        //return Redirect::route('job.index')->with('message', 'Your Wallet is empty, Recharge your wallet!');
        return $this->withMessage('Your Wallet is empty, Recharge your wallet!','error');
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
