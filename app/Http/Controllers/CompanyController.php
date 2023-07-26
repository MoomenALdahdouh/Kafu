<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use App\Traits\Messages;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    use Messages, UserTrait;

    protected $companyservice;

    public function __construct(CompanyService $companyservice)
    {
        $this->companyservice = $companyservice;
    }

    public function index(Request $request)
    {
        $data = $this->companyservice->getAllCompanies($request);
        return Inertia::render('company/index', [
            'items' => $data,
            'incubator_key' => auth('web')->user()->incubator->key,
            'permissions' => getUserPermissions(),
            'notifications' => getNotifications(auth("web")->user()->id),
        ]);
    }

    public function create(Request $request)
    {
        return $this->companyservice->createCompany($request);
    }

    public function store(CompanyRequest $request)
    {
        $company = $this->companyservice->storeCompany($request);
        if ($company)
            return $this->withMessage('Success create company!');
        return $this->withMessage('Failed to create company!, try again.', 'error');
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
