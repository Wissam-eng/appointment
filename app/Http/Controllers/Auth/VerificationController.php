<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Verified;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function verifyEmail(Request $request)
    {
        // تحقق من وجود التوكين في الطلب
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
        ]);

        // إذا كان هناك أخطاء في البيانات المدخلة
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid data', 'messages' => $validator->errors()], 400);
        }

        // البحث عن المستخدم بناءً على البريد الإلكتروني
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // تحقق من التوكين
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        if ($request->token != $user->verification_token) {
            return response()->json(['error' => 'Invalid verification token'], 400);
        }

        // تغيير حالة البريد الإلكتروني إلى مؤكد
        $user->markEmailAsVerified();

        // إطلاق حدث لتأكيد البريد الإلكتروني
        event(new Verified($user));

        return response()->json(['message' => 'Email successfully verified'], 200);
    }
}
