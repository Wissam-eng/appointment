<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Doctors;
use App\Models\room;
use App\Models\User;
use App\Models\appointments;
use App\Models\operations;
use App\Models\room_types;
use App\Models\analysis;
use App\Models\specialization;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class FacilityController extends Controller
{



    public function __construct()
    {

        // Middleware for Web routes
        $this->middleware('auth');
        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
        $this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }









    public function index()
    {
        $facilities = Facility::all();
        return view('facilities.index', compact('facilities'));
    }



    public function injured()
    {

        $patients = User::where('user_type', 3)->with('profile')->get();
        return view('patients.index', compact('patients'));
    }





    public function get_facilitiy($id)
    {
        $Clinics = Facility::where('facility_type', 2)->get();
        return view('clinics.index')->with('Clinics', $Clinics);
    }





    public function hospitals()
    {

        if (Auth::user()->user_type == 2) {

            $facilities = Facility::where(['manager_id' => Auth::user()->id, 'facility_type' => 1])->with(['user'])->get();
        } else {

            $facilities = Facility::where('facility_type', 1)->with(['user'])->get();
        }

        return view('facilities.index', compact('facilities'));
    }


    public function clinics()
    {
        if (Auth::user()->user_type == 2) {
            # code...
            $Clinics = Facility::where(['manager_id' => Auth::user()->id, 'facility_type' => 2])->with(['user'])->get();
        } else {
            $Clinics = Facility::where('facility_type', 2)->with(['user'])->get();
        }


        $facility_type = 2;
        return view('clinics.index', compact('Clinics', 'facility_type'));
    }

    public function pharmacys()
    {
        if (Auth::user()->user_type == 2) {
            # code...
            $Clinics = Facility::where(['manager_id' => Auth::user()->id, 'facility_type' => 4])->with(['user'])->get();
        } else {
            $Clinics = Facility::where('facility_type', 4)->with(['user'])->get();
        }


        $facility_type = 4;
        return view('pharmacys.index', compact('Clinics', 'facility_type'));
    }
    public function company()
    {
        if (Auth::user()->user_type == 2) {
            # code...
            $Clinics = Facility::where(['manager_id' => Auth::user()->id, 'facility_type' => 5])->with(['user'])->get();
        } else {
            $Clinics = Facility::where('facility_type', 5)->with(['user'])->get();
        }


        $facility_type = 5;
        return view('pharmacys.index', compact('Clinics', 'facility_type'));
    }


    public function centers()
    {
        $Clinics = Facility::where('facility_type', 3)->with(['user'])->get();
        $facility_type = 3;
        return view('clinics.index', compact('Clinics', 'facility_type'));
    }


    public function pharmacies()
    {
        $Clinics = Facility::where('facility_type', 4)->with(['user'])->get();
        return view('pharmacys.index', compact('Clinics'));
    }




    public function create()
    {
        return view('facilities.create');
    }




    public function store(Request $request, Facility $Facility)
    {
        // Extract all inputs except the profile picture
        $inputs = $request->except(['profile_pic', 'mobile']);

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            if ($Facility->profile_pic) {
                $oldImagePath = public_path($Facility->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('profile_pic');
            $filePath = $file->store('images', 'public');
            $inputs['profile_pic'] = '/storage/' . $filePath;
        }

        // Combine mobile numbers if the 'mobile' field is an array
        if ($request->has('mobile') && is_array($request->mobile)) {
            $inputs['mobile'] = implode(',', array_filter($request->mobile)); // Join mobiles with commas and remove empty values
        }

        // Create the facility record
        $facility = Facility::create($inputs);

        return redirect()->route('facilities.index')->with('success', 'Facility created successfully.');
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

        if ($hospital->facility_type == 4) {
            return view('pharmacys.show')->with([
                'hospital' => $hospital,
                'counts' => $counts,
                'facility_type' => $hospital->facility_type,
            ]);
        } else {

            return view('clinics.show')->with([
                'hospital' => $hospital,
                'counts' => $counts,
                'facility_type' => $hospital->facility_type,
            ]);
        }
    }


    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        
      
        // Prepare inputs for updating
        $inputs = $request->except(['profile_pic', 'mobile']);
    
        // Handle mobile numbers if provided
        if ($request->has('mobile') && is_array($request->mobile)) {
            $inputs['mobile'] = implode(',', array_filter($request->mobile)); // Combine into a comma-separated string
        }
    
        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            // Delete old image if exists
            if ($facility->profile_pic) {
                $oldImagePath = public_path($facility->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            // Store the new image and update the path
            $file = $request->file('profile_pic');
            $filePath = $file->store('images', 'public');
            $inputs['profile_pic'] = '/storage/' . $filePath;
        }
    
        // Update the facility
        $facility->update($inputs);
    
        return redirect()->route('facilities.index')->with([
            
            'message' => 'Facility updated successfully.',
          
        ], 200);
    }
    

    public function trashed_clinic()
    {
        $Clinics_deleted = Facility::onlyTrashed()->where('facility_type', 2)->get();
        return redirect()->route('clinics.trash')->with('Clinics_deleted', $Clinics_deleted);
    }







    public function trashed_hospital()
    {
        $hospitals_deleted = Facility::onlyTrashed()->where('facility_type', 1)->get();

        return view('hospitals.trash')->with('hospitals_deleted', $hospitals_deleted);
    }


    public function trash_pharmacys()
    {
        $Clinics_deleted = Facility::onlyTrashed()->where('facility_type', 4)->get();

        return view('pharmacys.trash')->with('Clinics_deleted', $Clinics_deleted);
    }



    public function trash()
    {
        $hospitals_deleted = Facility::onlyTrashed()->get();

        return view('hospitals.trash')->with('hospitals_deleted', $hospitals_deleted);
    }


    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->back()->with('success', 'Facility deleted successfully.');
    }


    public function apiIndex($id)
    {
        $facilities = Facility::where('facility_type', $id)->get();

        if ($facilities->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No Facility found'
            ]);
        }

        return response()->json([
            'success' => true,
            'facilities' => $facilities
        ]);
    }


    public function apiStore(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'mobile' => 'nullable|array', // Expecting mobile as an array
            'mobile.*' => 'nullable|string|max:15', // Each mobile entry must be a string of max 15 characters
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Prepare inputs for saving
        $inputs = $request->except(['profile_pic', 'mobile']);

        // Handle mobile numbers if provided
        if ($request->has('mobile') && is_array($request->mobile)) {
            $inputs['mobile'] = implode(',', array_filter($request->mobile)); // Combine into a comma-separated string
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filePath = $file->store('images', 'public');
            $inputs['profile_pic'] = '/storage/' . $filePath;
        }

        // Create facility
        $facility = Facility::create($inputs);

        return response()->json([
            'success' => true,
            'message' => 'Facility created successfully.',
            'data' => $facility,
        ], 201);
    }





    public function apiShow($id)
    {
        // Find the facility by ID
        $facility = Facility::find($id);
        if (!$facility) {
            return response()->json(['message' => 'Facility not found'], 404);
        }
    
        // Fetch doctors based on the establishment_id (which should be the same as facility id) and facility_type
        $doctor = Doctors::select('doctors.*', 'rates.rate')
            ->where([
                'doctors.Establishment_id' => $id,
                'doctors.facility_type' => $facility->facility_type
            ])
            ->leftJoin('rates', 'rates.doctor_id', '=', 'doctors.id') // Join with the rates table to fetch rates
            ->with(['specialization', 'appointments']) // Eager load relations to minimize queries
            ->get();
    
        // Fetch related analysis records for the facility
        $analysis = Analysis::where('facility_id', $facility->id)->get();
    
        // Fetch related operations records for the facility
        $operations = Operations::where('facility_id', $facility->id)->get();
    
        // Fetch specializations related to the facility (without the commented out code)
        $specializations = Specialization::where('facility_id', $facility->id)->get();
    
        // Fetch rooms available in the facility and eager load related room class and room type
        $rooms = Room::where([
            'facility_id' => $id,
            'facility_type' => $facility->facility_type
        ])
        ->with(['roomClass', 'roomType'])
        ->get();
    
        // Return a structured response with all the related data
        return response()->json([
            'success' => true,
            'facility' => $facility,
            'specializations' => $specializations,
            'analysis' => $analysis,
            'operations' => $operations,
            'rooms' => $rooms,
            'doctor' => $doctor,
        ]);
    }
    




    public function apiUpdate(Request $request, $id)
    {
        $facility = Facility::find($id);
        if (!$facility) {
            return response()->json(['message' => 'Facility not found'], 404);
        }



        $facility->update($request->all());
        return response()->json($facility);
    }




    public function apiDestroy($id)
    {
        $facility = Facility::find($id);
        if (!$facility) {
            return response()->json(['message' => 'Facility not found'], 404);
        }

        $facility->delete();
        return response()->json(['message' => 'Facility deleted successfully.']);
    }

    public function apiForceDestroy($id)
    {
        $facility = Facility::withTrashed()->find($id);
        if (!$facility) {
            return response()->json(['message' => 'Facility not found'], 404);
        }

        $facility->forceDelete();
        return response()->json(['message' => 'Facility permanently deleted successfully.']);
    }

    public function apiRestore($id)
    {
        $facility = Facility::withTrashed()->find($id);
        if (!$facility) {
            return response()->json(['message' => 'Facility not found'], 404);
        }

        $facility->restore();
        return response()->json(['message' => 'Facility restored successfully.']);
    }
}
