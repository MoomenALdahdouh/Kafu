<?php


use App\Models\Company;
use App\Models\Job;

function getUserPermissions()
{
    return auth('web')->user()->getPermissionsViaRoles()->pluck('name');
}

function getCompany()
{
    if (auth()->user()->can('company'))
        if (company())
            return company();
        else
            return Company::query()->where('user_id', auth('web')->user()->id)->get()->first()->id;
}

function incubator()
{
    return auth('web')->user()->incubator;
}

function incubatorKey()
{
    return auth('web')->user()->can("incubator") ? incubator()->key : auth('web')->user()->company->incubator_key;
}

function company()
{
    return auth('web')->user()->company;
}

function incubator_key()
{
    $incubator_key = null;
    if (incubator())
        $incubator_key = incubator()->key;
    else
        $incubator_key = company()->incubator_key;
    return $incubator_key;
}

function companyId($company_id)
{
    if (!$company_id)
        $company_id = Company::query()->where('user_id', auth('web')->user()->id)->get()->first()->id;
    return $company_id;
}


function findCompany($id)
{
    $company = Company::query()->find($id);
    if (!$company)
        $company = Company::query()->where('user_id', auth('web')->user()->id)->get()->first();
    return $company;
}
