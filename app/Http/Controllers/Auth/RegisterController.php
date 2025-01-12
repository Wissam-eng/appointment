<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\profile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CustomVerifyEmail;
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
    
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 3,
            'password' => Hash::make($data['password']),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $data['name'] ?? null,
            'second_name' => $data['second_name'] ?? null,
            'third_name' => $data['third_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'date_birth' => $data['date_birth'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'old' => $data['old'] ?? null,
            'gender' => $data['gender'] ?? null,
            'martial_status' => $data['martial_status'] ?? null,
            'department_id' => $data['department_id'] ?? null,
            'nationality' => $data['nationality'] ?? null,
            'certification' => $data['certification'] ?? null,
            'profile_pic' => $data['profile_pic'] ?? null,
        ]);
        // $user->notify(new CustomVerifyEmail());
        return $user;
    }
}
