<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Incubator;
use App\Models\Plan;
use App\Traits\Messages;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class CompanyService
{

    use Messages, UserTrait;

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
            return Inertia::render('company/register', ['incubator_key', $request->incubator]);
        else
            return Inertia::render('company/notfound');
    }

    public function storeCompany(Request $request)
    {
        $incubator = Incubator::where('key', Session::get('incubator_key'))->first();
        $request_all = $request->all();
        $request_all["type"] = 1;
        $request_all["permission"] = 'Company';
        DB::beginTransaction();
        try {
            $user = $this->createUser($request_all);

            if (!$incubator) {
                $incubator = auth()->user()->incubator;
            }
            $plan = Plan::where('type', 1)->firstOrFail();
            $company = Company::create([
                'key' => uniqid(),
                'user_id' => $user->id,
                'incubator_key' => $incubator->key,
                'incubator_id' => $incubator->id,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'wallet' => $plan->budget,
                'status' => 1,
                'name_officer' => $request->name_officer,
            ]);
            CompanyPlan::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'company_id' => $company->id,
                'name' => $plan->name,
                'description' => $plan->description,
                'price' => $plan->price,
                'days' => $plan->days,
                'budget' => $plan->budget,
            ]);
            DB::commit();
            return $this->withMessage('Success create company!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->withMessage('Resource not found', 'error');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->withMessage('Something went wrong', 'error');
        }
    }

}
