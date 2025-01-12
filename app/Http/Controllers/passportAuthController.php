<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\profile;
use App\Models\review;
use App\Models\ClientAdvertisement;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Mail\Mailable;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class passportAuthController extends Controller
{



    // public function register(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:8'
    //     ]);

    //     $request['user_type'] = 3;
    //     // Create the user
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'user_type' => $request->user_type,
    //         'password' => bcrypt($request->password)
    //     ]);

    //     // Create a personal access token
    //     $tokenResult = $user->createToken('$B_@bed');
    //     $token = $tokenResult->accessToken; // Access the token

    //     // Return the token in the response
    //     return response()->json(['token' => $token], 200);
    // }




    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $request['user_type'] = 3;

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => bcrypt($request->password),
            'verification_token' => Str::random(60),  // توليد توكين عشوائي
        ]);


        Profile::create([
            'user_id' => $user->id,
            'first_name' => $user->name ,
            'second_name' => null,
            'third_name' =>  null,
            'last_name' =>  null,
            'date_birth' =>  null,
            'mobile' =>  null,
            'old' =>  null,
            'gender' =>  null,
            'martial_status' => null,
            'department_id' =>  null,
            'nationality' =>  null,
            'certification' =>  null,
            'profile_pic' =>  null,
        ]);

        // إرسال البريد الإلكتروني لتأكيد الحساب
        // Mail::to($user->email)->send(new EmailVerification($user));

        // Create a personal access token
        $tokenResult = $user->createToken('$B_@bed');
        $token = $tokenResult->accessToken;

        // Return the token in the response
        return response()->json(['token' => $token], 200);
    }





    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $user = auth()->user();
            // $user = User::where(['email' => $request->email, 'password' => $request->password])->first();

            $Facility = Facility::where('manager_id', $user->id)->first();



            // Create a personal access token
            $tokenResult = $user->createToken('$B_@bed');

            $token = $tokenResult->accessToken;
            session(['user_id' => $user->id]);

            // Format expires_at in 'h:i A' format for AM/PM time
            $expiresAt = $tokenResult->token->expires_at->format('Y-m-d h:i A');


            if ($user->user_type == 2) {
                
               
                # code...
                if ($Facility) {

                    // $Facility_id = $Facility->pluck('id');
                    $hospital = Facility::with([
                        'doctors',
                        'user',
                        'employees',
                        'rooms',
                        'appointments',
                        'stock',
                        'cart',
                    ])->find($Facility->id);
                    
                    
                    

                    $Adds = ClientAdvertisement::where('status', 'active')->get();

                    $review = review::where('Facility_id', $Facility->id)->count();

                    // الحصول على عدد الأطباء لكل تخصص
                    $specialtiesCount = $hospital->doctors->groupBy('specialization')->map(function ($doctors) {
                        return $doctors->count();
                    });

                    $patients = $hospital->user->where('user_type', 3)->count();

                    $counts = [
                        'doctors' => $hospital->doctors->count(),
                        'users' => $hospital->user->count(),
                        'employees' => $hospital->employees->count(),
                        'rooms' => $hospital->rooms->count(),
                        'appointments' => $hospital->appointments->count(),
                        'stock' => $hospital->stock->count(),
                        'cart' => $hospital->cart->count(),
                        'specialtiesCount' => $specialtiesCount->count(),
                        'review' => $review,
                        'patients' =>  $patients,

                    ];



                    return response()->json([
                        'token' => $token,
                        'expires_at' => $expiresAt,
                        'user_id' => session('user_id'),
                        'user_data' => $user,
                        'Facility' => $Facility,
                        'Adds' => $Adds,

                        '$counts' => $counts
                    ], 200);
                } else {
                    return response()->json([
                        'token' => $token,
                        'expires_at' => $expiresAt,
                        'user_id' => session('user_id'),
                        'user_data' => $user
                    ], 200);
                }
            } else {
                return response()->json([
                    'token' => $token,
                    'expires_at' => $expiresAt,
                    'user_id' => session('user_id'),
                    'user_data' => $user
                ], 200);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }






    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
