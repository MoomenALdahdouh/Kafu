<?php

namespace App\Http\Controllers;

use App\Traits\PlanTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    use PlanTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Inertia::render('home', [
            'permissions' => getUserPermissions(),
            'wallet'=> auth()->user()->can('company') ? $this->getWallet(getCompany()) : '',
        ]);
    }
}
