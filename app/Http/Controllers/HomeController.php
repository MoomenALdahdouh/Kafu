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
        if (auth('web')->user()->type == 0)
            return Inertia::render('incubator');
        else
            return Inertia::render('company');
    }
}
