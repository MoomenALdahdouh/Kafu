<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Http\Request;

class JobService
{
    public function getAllJobs(Request $request)
    {
        return Job::published(false)
            ->forCompany()
            ->forIncubator(incubator_key())
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
    }

    public function getJob($id){
        return Job::find($id);
    }

}
