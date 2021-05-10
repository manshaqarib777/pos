<?php

namespace App\Http\Controllers\Auth;

use App\Events\LogActivity;
use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     Where to redirect users after registration.

     @var string
     */
    protected $redirectTo = '/user';
    /**
     Create a new controller instance. guest

     @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     Get a validator for an incoming registration request.

     @param  array $data
     @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'max:225'], 'phone' => ['required'],
            'company' => ['required', 'string'],
            'country_id' => ['required'],
            ]
        );
    }
    /**
     Create a new user instance after a valid registration.

     @param  array $data
     @return \App\User
     */
    protected function create(array $data)
    {
        $image = 'default_img/no_image.png';
        if (request()->hasFile('image')) {
            request()->validate(
                [
                'image' => 'required|image|file',
                ]
            );
            $image = request()->image->store('uploads/user', 'public');
        }
        $user = User::create(
            [
            'group_id' => $this->bluePrints()->default_group ?? 1,
            'pin' => '12345',
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'company' => $data['company'],
            'country_id' => $data['country_id'],
            'image' => $image,
            'isActive' => 0,
            'password' => Hash::make($data['password']),
            ]
        );

        event(new LogActivity($user->name, 'New user created', 'User'));
        Session::flash('success', 'New user created successfully');
        return $user;
    }
}
