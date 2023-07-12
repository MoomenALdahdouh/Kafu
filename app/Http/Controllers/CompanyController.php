<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\CompanyPlan;
use App\Models\Incubator;
use App\Models\Plan;
use App\Models\User;
use App\Traits\Messages;
use App\Traits\Searchable;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class CompanyController extends Controller
{
    use Messages, UserTrait;

    public function index(Request $request)
    {
        $data = Company::query()
            ->forIncubator(auth('web')->user()->incubator->key)
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
        return Inertia::render('company/index', [
            'items' => $data,
            'incubator_key' => auth('web')->user()->incubator->key,
            'permissions' => getUserPermissions(),
        ]);
    }

    public function create_company(Request $request)
    {
        $incubator = Incubator::query()->where('key', $request->incubator)->get()->first();
        Session::put('incubator_key', $request->incubator);

        if ($incubator)
            return Inertia::render('company/register');
        else
            return Inertia::render('company/notfound');
    }

    public function store_company(CompanyRequest $request)
    {
        $incubator = null;
        if (Session::get('incubator_key'))
            $incubator = Incubator::query()->where('key', Session::get('incubator_key'))->get()->first();
        if ($incubator) {
            $request_all = $request->all();
            $request_all["type"] = 1;
            $request_all["permission"] = 'Company';
            $user = $this->createUser($request_all);
            if ($user) {
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
                $plan = Plan::query()->get()->firstOrFail();
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
            }
        } else
            return Inertia::render('company/notfound');
        return redirect(url('login'));
    }


    public function store(CompanyRequest $request)
    {
        $request_all = $request->all();
        $request_all["type"] = 1;
        $request_all["permission"] = 'Company';
        $user = $this->createUser($request_all);
        if ($user) {
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
            $plan = Plan::query()->get()->where('type',1)->firstOrFail();
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
        }
        return $this->withMessage('Success create company!');
    }

    public function update(Company $company, UpdateCompanyRequest $request)
    {
        $company->update($request->all());
        return $this->withMessage('Success edit company!');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return $this->withMessage('Success delete company!');
    }
}
