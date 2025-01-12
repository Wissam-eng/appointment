<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords;

    // عرض صفحة إرسال رابط إعادة تعيين كلمة المرور
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // إرسال رابط إعادة تعيين كلمة المرور عبر البريد
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

    // عرض نموذج إعادة تعيين كلمة المرور
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // تنفيذ عملية إعادة تعيين كلمة المرور
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:1',
            'token' => 'required',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($response))
            : back()->withErrors(['email' => [__($response)]]);
    }
}

