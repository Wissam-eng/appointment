<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Facility;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    protected function authenticated($request, $user)
    {
        session(['user_type' => $user->user_type]);

        if ($user->user_type == 1) {

            return redirect()->intended($this->redirectTo);
            
        } elseif ($user->user_type == 2) {
            session(['user_id' => $user->id]);
            session(['facility_id' => $user->facility_id]);
            $facility = Facility::where('id', $user->facility_id)->first();
            session(['user_type' => $user->user_type]);
            if ($facility) {
                session(['facility_type' => $facility->facility_type]);
            }

            return redirect()->intended($this->redirectTo);
        }


        return redirect()->route('logout')->with('error', 'Unauthorized access. Please log in again.');
    }
}
