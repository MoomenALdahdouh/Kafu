<?php

namespace App\Http\Controllers;

use App\Models\Incubator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class IncubatorController extends Controller
{
    public function index(Request $request)
    {
        $data = Incubator::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })
            ->paginate($request->page_size ?? 10);
        return Inertia::render('incubator/index', [
            'items' => $data,
        ]);
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
        $user->assignRole('Incubator');
        if ($user) {
            $incubator = Incubator::query()->where('user_id', auth('web')->user()->id)->get()->first();
            $incubator = Incubator::create([
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
            'text' => 'Success create incubator!',
        ]);
    }

    public function update(Incubator $incubator, Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'name_officer' => 'required|string',
            'mobile' => 'required',
        ]);

        $incubator->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success edit incubator!',
        ]);
    }

    public function destroy(Incubator $incubator)
    {
        $incubator->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Success delete incubator!',
        ]);
    }
}
