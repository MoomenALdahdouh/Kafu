<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Incubator;
use App\Models\Plan;
use App\Models\User;
use App\Traits\Messages;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class PlanController extends Controller
{
    use Messages, UserTrait;

    public function index(Request $request)
    {
        $data = Plan::query()
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
        return Inertia::render('plan/index', [
            'items' => $data,
            'permissions' => getUserPermissions(),
        ]);
    }

    public function store(StorePlanRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 1,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            $incubator = Incubator::query()->where('user_id', auth('web')->user()->id)->get()->first();
            $plan = Plan::create([
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
            'text' => 'Success create plan!',
        ]);
    }

    public function update(Plan $plan, UpdatePlanRequest $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'name_officer' => 'required|string',
            'mobile' => 'required',
        ]);

        $plan->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success edit plan!',
        ]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success delete plan!',
        ]);
    }
}
