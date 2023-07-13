<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Incubator;
use App\Models\Plan;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CompanyService
{

    use UserTrait;

    public function getAllCompanies(Request $request)
    {
        return Company::published()
            ->forIncubator(auth('web')->user()->incubator->key)
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
    }

    public function createCompany(Request $request)
    {
        $incubator = Incubator::query()->where('key', $request->incubator)->get()->first();
        Session::put('incubator_key', $request->incubator);

        if ($incubator)
            return Inertia::render('company/register');
        else
            return Inertia::render('company/notfound');
    }

    public function storeCompany(Request $request)
    {
        $incubator = null;
        if (Session::get('incubator_key'))
            $incubator = Incubator::query()->where('key', Session::get('incubator_key'))->get()->first();
        $request_all = $request->all();
        $request_all["type"] = 1;
        $request_all["permission"] = 'Company';
        $user = $this->createUser($request_all);
        if ($user) {
            if (!$incubator)
                $incubator = Incubator::query()->where('user_id', auth('web')->user()->id)->get()->first();
            $company = Company::create([
                'key' => uniqid(),
                'user_id' => $user->id,
                'incubator_key' => $incubator->key,
                'incubator_id' => $incubator->id,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'name_officer' => $request->name_officer,
            ]);
            $plan = Plan::query()->get()->where('type', 1)->firstOrFail();
            if ($plan)
                $c_plan = CompanyPlan::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'company_id' => $company->id,
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'price' => $plan->price,
                    'days' => $plan->days,
                    'budget' => $plan->budget,
                ]);
            if ($company && $company)
                return $company;
        }
        return null;
    }

}
