<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AdminAuthController extends Controller
{
    public function index()
    {
        return Inertia::render("admin/index");
    }

    public function auth()
    {
        return Inertia::render('admin/login');
    }


    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect()->back();
    }

    public function account()
    {
        $user = auth()->guard("admin")->user();
        return view("admin.account.profile", compact("user"));
    }

    public function login(Request $request)
    {
        // Validate the form input
        $credentials = Validator::make(request()->all(), [
            'email' => 'required:admins,email',
            'password' => 'required',
        ]);

        if ($credentials->passes()) {
            $user = Admin::query()->where('email',$request->email)->get()->first();
            //Auth::guard('admin')->login($user);
            Auth::guard("admin")->attempt(['email' => $request->email, 'password' => $request->password]);
            return redirect(url('admin'));
        }
        else{
            $convertedMessages = array_combine(
                array_keys($credentials->errors()->toArray()),
                array_map(function ($errors) {
                    return $errors[0];
                }, $credentials->errors()->toArray())
            );
            return Inertia::render('admin/auth', [
                'errors' => $convertedMessages,
                /*'appName' => 'Laravel',
                'canResetPassword' => true,
                'status' => null,
                'auth' => [
                    'user' => null,
                ],*/
            ]);
        }

        //return redirect()->route('admin');
    }

    public function check_auth_type()
    {
        if (auth("admin")->user()->status == 0)
            return response()->json(['error_sing_in' => 'Your account has been blocked!']);
        return response()->json(['success' => "success sign"]);

    }

    public function check()
    {
        //dd(Auth::guard()->user());
        if (Auth::guard("admin")->user())
            return response()->json(['success' => "success"]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => time(),
            'name' => 'required:admins,name',
            'last_name' => 'required:admins,last_name',
            'email' => 'required|unique:admins,email',
            'mobile' => 'required|unique:admins,mobile|max:8',
            'password' => 'required|min:8|confirmed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]/*, [
            'name.required' => trans('Req name'),
            'last_name.required' => trans('Req last_name'),
            'email.required' => trans('Req email'),
            'mobile.required' => trans('Req mobile'),
            'password.required' => trans('Req password'),
        ]*/);
        if ($validator->passes()) {
            $user = Admin::query()->create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'image' => 'blank.svg',
                'password' => Hash::make($request->password),
            ]);
            if ($user) {
                $validator_auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
                if ($validator_auth)
                    return response()->json(['success' => "success register"]);
            } else {
                return response()->json(['error' => "failed register"]);
            }
        } else {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    public
    function update(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::query()->find(auth()->guard("admin")->user()->id);
            $old_email = $data->email;
            $old_mobile = $data->mobile;
            $old_image = "uploads/users/$data->image";
            $validator = [];
            if (($old_email != $request->email) && $request->email) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required:admins,name',
                    'email' => 'required|unique:admins,email',
                    'password' => 'string|confirmed|required',
                ], [
                    'name.required' => 'This field is required!',
                    'email.required' => 'This field is required!',
                    'email.email' => 'The selected email is invalid.',
                    'email.unique' => 'This field must be unique',
                    'password.required' => 'This field is required!',
                    'password_confirmation.required' => 'This field is required!',
                    'password_confirmation.same' => 'The Password does not match',
                ]);
            } else if (($old_mobile != $request->mobile) && $request->mobile) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required:admins,name',
                    'mobile' => 'required|unique:admins,mobile|digits:10',
                ], [
                    'name.required' => 'This field is required!',
                    'mobile.required' => 'This field is required!',
                    'mobile.digits' => 'The mobile must be 10 digits!',
                    'mobile.unique' => 'This field must be unique',
                ]);
            } else if (!$request->mobile && !$request->email) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required:admins,name',
                    'email' => 'required|unique:admins,email',
                    'mobile' => 'required|unique:admins,mobile|digits:10',
                    'password' => 'required|string|confirmed',
                ], [
                    'name.required' => 'This field is required!',
                    'email.required' => 'This field is required!',
                    'email.email' => 'The selected email is invalid.',
                    'email.unique' => 'This field must be unique',
                    'mobile.required' => 'This field is required!',
                    'mobile.digits' => 'The mobile must be 10 digits!',
                    'mobile.unique' => 'This field must be unique',
                    'password.required' => 'This field is required!',
                    /*'password.min' => trans(convertToJsonKey('The password must be at least 8 characters.','val.')),*/
                    'password_confirmation.required' => 'This field is required!',
                    'password_confirmation.same' => 'The Password does not match',
                ]);
            } else if (!$request->mobile) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required:admins,name',
                    'mobile' => 'required|unique:admins,mobile|digits:10'
                ], [
                    'name.required' => 'This field is required!',
                    'mobile.required' => 'This field is required!',
                    'mobile.digits' => 'The mobile must be 10 digits!',
                    'mobile.unique' => 'This field must be unique',
                ]);
            } else if (!$request->email) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required:admins,name',
                    'email' => 'required|unique:admins,email',
                ], [
                    'name.required' => 'This field is required!',
                    'email.required' => 'This field is required!',
                    'email.email' => 'The selected email is invalid.',
                    'email.unique' => 'This field must be unique',
                ]);
            } else if ($request->password) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|string|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,10}$/',
                    'password_confirmation' => 'required|same:password'
                ], [
                    'password.required' => 'This field is required!',
                    'password.regex' => 'The word must be 6-10 letters long and contain a capital letter, numbers and symbols!',

                    'password_confirmation.required' => 'This field is required!',
                    'password_confirmation.same' => 'The Password does not match',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required:admins,name',
                ], [
                    'name.required' => 'This field is required!',
                ]);
            }
            if ($validator->passes()) {
                //dd($request->user_image);
                $image = uniqid() . '.jpg';
                $image_path = "uploads/users/$image";
                file_put_contents($image_path, base64_decode($request->user_image));
                if ($request->image_updated == 1)
                    $data->image = $image;
                //$data->image = $image;
                $data->name = $request->name;
                $data->last_name = $request->last_name;
                $data->email = $request->email;
                $data->mobile = $request->mobile;
                $data->status = 1;
                $data->updated_at = Carbon::now();
                if ($request->password) {
                    $data->password = Hash::make($request->password);
                }
                $data->save();
                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
