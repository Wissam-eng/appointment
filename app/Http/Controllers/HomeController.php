<?php

namespace App\Http\Controllers;

use App\Models\appointments;
use App\Models\Facility;
use App\Models\User;
use App\Models\Cart;
use App\Models\review;
use App\Models\operations;
use App\Models\analysis;
use App\Models\categorys;
use App\Models\ClientAdvertisement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // return view('home');
        if (session('user_type') == 1) {

            $hospital = Facility::where('facility_type', 1)->get();
            $clinics = Facility::where('facility_type', 2)->get();
            $centers = Facility::where('facility_type', 3)->get();
            $pharmacy = Facility::where('facility_type', 4)->get();
            $company = Facility::where('facility_type', 5)->get();




            $counts = [
                'hospital' => $hospital->count(),
                'clinics' => $clinics->count(),
                'centers' => $centers->count(),
                'pharmacy' => $pharmacy->count(),


            ];

            return view('home')->with([
                'counts' => $counts,
            ]);
        } elseif (session('user_type') == 2) {

            $id = session('facility_id');

            $hospital = Facility::with([
                'doctors',
                'user',
                'employees',
                'rooms',
                'appointments',
                'stock',
                'cart',
            ])->findOrFail($id);

            // الحصول على عدد الأطباء لكل تخصص
            $specialtiesCount = $hospital->doctors->groupBy('specialization')->map(function ($doctors) {
                return $doctors->count();
            });
            if ($hospital->user) {
                # code...
                $patients = $hospital->user->where('user_type', 3)->count();
            } else {
                $patients = null;
            }

            $counts = [
                'doctors' => $hospital->doctors->count(),
                // 'users' => $hospital->user->count(),
                'employees' => $hospital->employees->count(),
                'rooms' => $hospital->rooms->count(),
                'appointments' => $hospital->appointments->count(),
                'stock' => $hospital->stock->count(),
                'cart' => $hospital->cart->count(),
                'specialtiesCount' => $specialtiesCount->count(),
                'patients' =>  $patients

            ];



            return view('home')->with([
                'hospital' => $hospital,
                'counts' => $counts,
            ]);
        }else{

          
        
            Auth::logout(); 
        
            return view('home')->with('error', 'You are not user facility or admin.');
        }
    }


public function index_api(Request $request)
{
    if ($request->user_type == 3) {
        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Retrieve the counts for each facility type
        $facilityCounts = Facility::whereIn('facility_type', [1, 2, 3, 4])
            ->get()
            ->groupBy('facility_type')
            ->map(fn($items) => $items->count());

            $Adds = ClientAdvertisement::whereNull('deleted_at')->get();

        $later_appointments = appointments::select(
            'id', 'facility_id', 'booking_type', 'booking_data', 'analysis_id', 
            'created_at', 'start_date', 'end_date', 'room_id', 'old_child', 
            'operation', 'user_id', 'doctor'
        )->with([
            'facilities:id,name',
            'booking_data:id,Dialysis_type,way',
            'analyses:id,analysis_name,analysis_pic',
            'operation:id,operation_name,specialization_id,operation_pic',
            'operation.specialization:id,specialization_name',
            'room:id,room_type,room_class',
            'room.roomType:id,room_type_name',
            'room.roomClass:id,roomsClass_name',
            'doctor:id,first_name,last_name,specialization_id,gender,profile_pic',
            'doctor.specialization:id,specialization_name',
        ])
        ->where('user_id', $request->user_id)
        ->where('start_date', '>=', Carbon::today())
        ->get();

        $facility = Facility::where('id', '1')->first();
        $suggested_facilities = Facility::where('Suggested', 'suggested')->get();

        return response()->json([
            'home' => [
                'Adds' => $Adds,
                'Offers' => $Adds,
                'later_appointments' => $later_appointments,
                'default_hospital_facility' => $facility,
                'suggested_facilities' => $suggested_facilities,
            ],
        ]);
    } elseif ($request->user_type == 2) {
        $id = $request->facility_id;

        if (!$id) {
            return response()->json(['error' => 'Facility ID not found in session'], 400);
        }

        $hospital = Facility::where('manager_id', $request->user_id)
            ->with(['doctors', 'user', 'employees', 'rooms', 'appointments', 'stock', 'cart'])
            ->find($id);

        if (!$hospital) {
            return response()->json(['error' => "You haven't a facility"], 404);
        }

        $specialtiesCount = $hospital->doctors->groupBy('specialization')->map(fn($doctors) => $doctors->count());
        $review = review::where('facility_id', $hospital->id)->count();
        $facility_id = $request->facility_id;

        $users = User::where('facility_id', $facility_id)->pluck('id');
        $my_orders = Cart::whereIn('user_id', $users)->with(['user', 'stock', 'facility'])->get()->groupBy('order_number')->count();

        $categories = categorys::where('facility_id', $hospital->id)->count();
        $analysis = analysis::where('facility_id', $hospital->id)->count();
        $operations = operations::where('facility_id', $hospital->id)->count();
            $Adds = ClientAdvertisement::whereNull('deleted_at')->get();
        $patients = User::whereHas('appointments', fn($query) => $query->where('facility_id', $id))->with('profile')->select('id')->count();

        $counts = [
            'doctors' => $hospital->doctors->count(),
            'employees' => $hospital->employees->count(),
            'rooms' => $hospital->rooms->count(),
            'appointments' => $hospital->appointments->count(),
            'stock' => $hospital->stock->count(),
            'orders_from_me' => $hospital->cart->count(),
            'review' => $review,
            'categories' => $categories,
            'analysis' => $analysis,
            'operations' => $operations,
            'my_orders' => $my_orders,
            'specialtiesCount' => $specialtiesCount->count(),
            'patients' => $patients,
        ];

        return response()->json([
            'hospital' => $hospital,
            'Adds' => $Adds,
            'counts' => $counts,
        ]);
    }

    return response()->json(['error' => 'Invalid user type'], 400);
}



    public function patients(Request $request)
    {

        if ($request->user_type == 2) {

            $id = $request->facility_id;

            $patients_data = User::whereHas('appointments', function ($query) use ($id) {
                $query->where('facility_id', $id);
            })->with('profile')->select('id')->get();

            return response()->json([
                'patients_data' => $patients_data

            ]);
        }
    }
}
