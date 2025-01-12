<?php

namespace App\Http\Controllers\Auth;

use App\Models\Facility;

use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;


class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home';


    public function showResetForm($token = null)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $user = Auth::user();



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

            // Continue with the redirect process
            return redirect()->intended($this->redirectTo);
        } elseif ($user->user_type == 3) {

            // إذا تم النجاح
            if ($response == Password::PASSWORD_RESET) {
                return response()->json(['message' => 'Password has been successfully reset.'], 200);
            } else {

                return response()->json(['message' => 'Failed to reset password.'], 400);
            }

            // إذا فشلت العملية


        } else {

            return redirect()->back()->with('message', 'Failed to reset password.');
            // return redirect($this->redirectTo)->with('status', trans($response));
        }
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return back()->withErrors(['email' => trans($response)]);
    }
}
