<?php

namespace App\Http\Controllers;

use App\Models\Facility; // تغيير الاسم هنا
use App\Models\specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{






    public function __construct()
    {

        // Middleware for Web routes
        $this->middleware('auth');
        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
        $this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }







    //------------------function web---------------------------------------------------

    public function index()
    {
        $hospitals = Facility::where('facility_type', 1)->with(['doctors', 'user'])->get();
        return view('hospitals.index')->with('hospitals', $hospitals);
    }

    public function index2()
    {


        if (session('user_type') == 1) {

            $hospitals = Facility::all(); // تغيير الاسم هنا
            return view('home')->with('hospitals', $hospitals);
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
                'patients' =>  $patients,

            ];

            return view('hospitals.show')->with([
                'hospital' => $hospital,
                'counts' => $counts,
            ]);
        }
    }




    public function all_hospital()
    {
        $hospitals = Facility::all(); // تغيير الاسم هنا
        return view('hospitals.hospitals')->with('hospitals', $hospitals);
    }

    public function doctors()
    {
        return view('hospitals.doctors.index');
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('profile_pic');
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $request['profile_pic'] = '/Storage' . $path_file;
        }
        Facility::create($input); // تغيير الاسم هنا
        return redirect('hospitals')->with('flash_message', 'hospital_added');
    }

    public function show($id)
    {
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
            'patients' =>  $patients,

        ];

        return view('hospitals.show')->with([
            'hospital' => $hospital,
            'counts' => $counts,
        ]);
    }





    public function trash()
    {
        $hospitals_deleted = Facility::onlyTrashed()->where('facility_type', 1)->get(); // تغيير الاسم هنا
        return view('hospitals.trash')->with('hospitals_deleted', $hospitals_deleted);
    }

    public function restore($id)
    {
        $hospital = Facility::withTrashed()->findOrFail($id); // تغيير الاسم هنا
        $hospital->restore();
        $hospitals = Facility::all(); // تغيير الاسم هنا
        return redirect()->back()->with('success', 'hospital restored successfully.');
    }

    public function edit($id)
    {
        $hospital = Facility::find($id); // تغيير الاسم هنا
        return view('hospitals.edit')->with('hospital', $hospital);
    }

    public function update(Request $request, Facility $hospital) // تغيير الاسم هنا
    {
        $input = $request->except('profile_pic');
        if ($request->hasFile('profile_pic')) {
            if ($hospital->profile_pic) {
                $oldImagePath = public_path($hospital->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('profile_pic');
            $file_path = $file->store('images', 'public');
            $input['profile_pic'] = '/storage/' .  $file_path;
        }
        $hospital->update($input);
        $hospitals = Facility::all(); // تغيير الاسم هنا
        return redirect()->route('hospitals.index')->with('hospitals', $hospitals)->with('flash_message', 'Hospital updated successfully!');
    }

    public function destroy($id)
    {
        $hospital = Facility::find($id); // تغيير الاسم هنا
        $hospital->delete();
        $hospitals = Facility::all(); // تغيير الاسم هنا
        return redirect()->route('hospitals.index')->with('hospitals', $hospitals)->with('success', 'hospital Trashed successfully.');
    }

    public function delete($id)
    {
        $hospital = Facility::withTrashed()->find($id); // تغيير الاسم هنا
        $hospital->forceDelete();
        $hospitals_deleted  = Facility::onlyTrashed()->get(); // تغيير الاسم هنا
        return redirect()->route('hospitals.trash')->with('hospitals_deleted', $hospitals_deleted)->with('success', 'hospital deleted successfully.');
    }


    public function logout()
    {
        Auth::logout(); // Logs out the user

        // Optionally, you can invalidate the session to avoid session fixation
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login_web'); // Redirect to the login page
    }

    //---------------------------------------------------------------------------------

    //-----------------------functions API----------------------------------------------------------

    public function index_api()
    {
    
        $hospitals = Facility::where('facility_type', 1)->with(['doctors'])->get();
        $specializations = specialization::all();
        return response()->json([
            'sucess' => true,
            'message' => 'all hospitals',
            'hospitals' => $hospitals,
            'specializations' => $specializations
        ]);
    }

    public function hospitals_list_api()
    {
      
        $hospitals = Facility::where('facility_type', 1)->get();
        return response()->json([
            'sucess' => true,
            'message' => 'all hospitals',
            'hospitals' => $hospitals,
        ]);
    }

    public function store_api(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15',
            'room_num' => 'required|integer|min:1'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'fail' => false,
                'message' => 'sorry not stored',
                'error' => $validator->errors()
            ]);
        }
        $hospital = Facility::create($inputs); // تغيير الاسم هنا
        return response()->json([
            'sucess' => true,
            'message' => 'hospitals created successfuly',
            'hospitals' => $hospital
        ]);
    }

    public function show_api($id)
    {
        $hospital = Facility::with(['doctors.specialization'])->findOrFail($id); // تغيير الاسم هنا
        if (is_null($hospital)) {
            return response()->json([
                'fail' => false,
                'message' => 'sorry not found'
            ]);
        }

        $specializations = [];

        foreach ($hospital->doctors as $doctor) {
            $specialization = $doctor->specialization;

            if ($specialization) {
                if (!isset($specializations[$specialization->id])) {
                    $specializations[$specialization->id] = [
                        'specialization_name' => $specialization->specialization_name,
                        'doctors' => []
                    ];
                }
                $specializations[$specialization->id]['doctors'][] = $doctor->toArray();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'hospitals successfully retrieved',
            'hospital' => [
                'id' => $hospital->id,
                'name' => $hospital->hospital_name,
                'specializations' => array_values($specializations)
            ]
        ]);
    }

    public function update_api(Request $request, Facility $hospital) // تغيير الاسم هنا
    {
        $input = $request->except('profile_pic');
        $validator = Validator::make($input, [
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15',
            'room_num' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }
        if ($request->hasFile('profile_pic')) {
            if ($hospital->profile_pic) {
                $oldImagePath = public_path($hospital->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('profile_pic');
            $file_path = $file->store('images', 'public');
            $input['profile_pic'] = '/storage/' . $file_path;
        }
        $hospital->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Hospital updated successfully',
            'hospital' => $hospital
        ]);
    }

    public function destroy_api($id)
    {
        $hospital = Facility::find($id); // تغيير الاسم هنا
        $hospital->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hospital trashed successfully',
            'hospital' => $hospital
        ]);
    }

    public function delete_api($id)
    {
        $hospital = Facility::withTrashed()->find($id); // تغيير الاسم هنا
        $hospital->forceDelete();
        return response()->json([
            'success' => true,
            'message' => 'Hospital deleted successfully',
            'hospital' => $hospital
        ]);
    }

    public function restore_api($id)
    {
        $hospital = Facility::withTrashed()->findOrFail($id); // تغيير الاسم هنا
        $hospital->restore();
        return response()->json([
            'success' => true,
            'message' => 'Hospital restored successfully',
            'hospital' => $hospital
        ]);
    }

    //-------------------------------------------------------------------------------------------------------
}
