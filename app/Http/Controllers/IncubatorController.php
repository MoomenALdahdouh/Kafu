<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncubatorRequest;
use App\Http\Requests\UpdateIncubatorRequest;
use App\Models\Incubator;
use App\Providers\RouteServiceProvider;
use App\Services\IncubatorService;
use App\Traits\Messages;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;


class IncubatorController extends Controller
{
    use Messages, UserTrait;

    protected $incubatorservice;

    public function __construct(IncubatorService $incubatorservice)
    {
        $this->incubatorservice = $incubatorservice;
    }

    public function index(Request $request)
    {
        $data = $this->incubatorservice->getAllIncubators($request);
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
        $this->incubatorservice->storeIncubator($request);
        return redirect(RouteServiceProvider::HOME);
    }

    public function update(Incubator $incubator, UpdateIncubatorRequest $request)
    {
        $incubator->update($request->all());
        return $this->withMessage('Success edit incubator!');
    }

    public function destroy(Incubator $incubator)
    {
        $incubator->delete();
        return $this->withMessage('Success delete incubator!');
    }
}
