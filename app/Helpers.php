<?php


use App\Models\Company;

function getUserPermissions(){
    return  auth('web')->user()->getPermissionsViaRoles()->pluck('name');
}


function incubator(){
    return auth('web')->user()->incubator;
}

function company(){
    return auth('web')->user()->company;
}

function incubator_key(){
    $incubator_key = null;
    if (incubator())
        $incubator_key = incubator()->key;
    else
        $incubator_key = company()->incubator_key;
    return $incubator_key;
}

function companyId($company_id){
    if (!$company_id)
        $company_id = Company::query()->where('user_id', auth('web')->user()->id)->get()->first()->id;
    return $company_id;
}
