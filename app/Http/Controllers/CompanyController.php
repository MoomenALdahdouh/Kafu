<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Incubator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $data = Company::query()->where('incubator_id', auth('web')->user()->id)
            ->when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })
            ->paginate($request->page_size ?? 10);
        return Inertia::render('company/index', [
            'items' => $data,
            'incubator_key' => auth('web')->user()->incubator->key,
        ]);
    }

    public function create_company(Request $request)
    {
        $incubator = Incubator::query()->where('key', $request->incubator)->get()->first();
        if ($incubator)
            return Inertia::render('company/register');
        else
            return Inertia::render('company/notfound');
    }

    public function store_company(Request $request)
    {
        //dd($request);
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'name_officer' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $incubator = Incubator::query()->where('key', $request->incubator)->get()->first();
        if ($incubator) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => 1,
                'password' => Hash::make($request->password),
            ]);


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
            }
        }

        return redirect(url('login'));
    }


    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'name_officer' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 1,
            'password' => Hash::make($request->password),
        ]);

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
        }


        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success create company!',
        ]);
    }

    public function update(Company $company, Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'name_officer' => 'required|string',
            'mobile' => 'required',
        ]);

        $company->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success edit company!',
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success delete company!',
        ]);
    }
}
