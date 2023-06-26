<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Incubator;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::query()->where('user_id', auth('web')->user()->id)->get()->first();
        $data = Job::query()->where('company_id', $company->id)
            ->when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('title', 'LIKE', '%' . $value . '%');
            })
            ->when($request->search, function ($query, $value) {
                $query->where('description', 'LIKE', '%' . $value . '%');
            })
            ->paginate($request->page_size ?? 10);
        return Inertia::render('job/index', [
            'items' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'salary' => 'required',
        ]);

        $company = Company::query()->where('user_id', auth('web')->user()->id)->get()->first();
        $job = Job::create([
            'user_id' => auth('web')->user()->id,
            'company_id' => $company->id,
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary,
        ]);

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success create job!',
        ]);
    }

    public function update(Job $job, Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'name_officer' => 'required|string',
            'mobile' => 'required',
        ]);

        $job->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success edit job!',
        ]);
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success delete job!',
        ]);
    }
}
