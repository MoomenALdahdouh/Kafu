<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncubatorRequest;
use App\Http\Requests\UpdateIncubatorRequest;
use App\Models\Incubator;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\Messages;
use App\Traits\UserTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class IncubatorController extends Controller
{
    use Messages, UserTrait;

    public function index(Request $request)
    {
        $data = Incubator::query()
            //->forIncubator(auth('web')->user()->incubator->key)
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
        return Inertia::render('incubator/index', [
            'items' => $data,
            'permissions' => getUserPermissions(),
        ]);
    }

    public function create()
    {
        return Inertia::render('auth/register');
    }

    public function store(StoreIncubatorRequest $request)
    {
        $request_all = $request->all();
        $request_all["type"] = 0;
        $request_all["permission"] = 'Incubator';
        $user = $this->createUser($request_all);
        if ($user)
            Incubator::create([
                'key' => uniqid(),
                'user_id' => $user->id,
                'name' => $request->in_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'projects' => $request->projects,
                'message' => $request->message,
            ]);

        event(new Registered($user));

        Auth::guard('web')->login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function update(Incubator $incubator, UpdateIncubatorRequest $request)
    {
        $incubator->update($request->all());
        return $this->withSuccessMessage('Success edit incubator!');
    }

    public function destroy(Incubator $incubator)
    {
        $incubator->delete();
        return $this->withSuccessMessage('Success delete incubator!');
    }
}
