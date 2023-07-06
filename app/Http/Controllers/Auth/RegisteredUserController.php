<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncubatorRequest;
use App\Models\Incubator;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\Messages;
use App\Traits\UserTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{

    use Messages, UserTrait;

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
}
