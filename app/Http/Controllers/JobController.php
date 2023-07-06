<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Company;
use App\Models\Incubator;
use App\Models\Job;
use App\Models\User;
use App\Traits\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class JobController extends Controller
{
    use Messages;

    public function index(Request $request)
    {
        $data = Job::query()
            ->forIncubator(auth('web')->user()->incubator->key)
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
        return Inertia::render('job/index', [
            'items' => $data,
            'companies' => incubator()->companies,
            'permissions' => getUserPermissions(),
        ]);
    }

    public function store(StoreJobRequest $request)
    {
        Job::create([
            'user_id' => auth('web')->user()->id,
            'company_id' => companyId($request->company_id),
            'incubator_key' => incubator_key(),
            'name' => $request->name,
            'description' => $request->description,
            'salary' => $request->salary,
        ]);
        return $this->withSuccessMessage('Success create job!');
    }

    public function update(Job $job, UpdateJobRequest $request)
    {
        $job->update($request->all());
        return $this->withSuccessMessage('Success edit job!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return $this->withSuccessMessage('Success delete job!');
    }
}
