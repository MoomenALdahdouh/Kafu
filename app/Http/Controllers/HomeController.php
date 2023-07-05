<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //dd(auth('web')->user()->roles->permissions);
        return Inertia::render('home', [
            'permissions' => getUserPermissions(),
        ]);
    }
}
