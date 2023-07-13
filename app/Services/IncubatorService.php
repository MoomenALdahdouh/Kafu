<?php

namespace App\Services;

use App\Models\Incubator;
use App\Traits\UserTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncubatorService
{

    use UserTrait;

    public function getAllIncubators(Request $request)
    {
        return Incubator::published()
            ->orderByField($request->sort_by, $request->order_by)
            ->search($request->search)
            ->paginate($request->page_size ?? 10);
    }

    public function storeIncubator(Request $request)
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
    }

}
