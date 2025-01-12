<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Facility; // تغيير هنا
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
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
        $Clinics = Facility::where('facility_type', 2)->get();
        return view('clinics.index')->with('Clinics', $Clinics);
    }



    public function index2()
    {
        $Clinics = Facility::all(); // تغيير هنا
        return view('home')->with('Clinics', $Clinics);
    }

    public function all_Clinic()
    {
        $Clinics = Facility::all(); // تغيير هنا
        return view('Clinics.Clinics')->with('Clinics', $Clinics);
    }

    public function doctors()
    {
        return view('Clinics.doctors.index');
    }

    public function create()
    {
        return view('Clinics.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('profile_pic');
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $request['profile_pic'] = '/Storage' . $path_file;
        }
      
        Facility::create($input); // تغيير هنا
        return redirect()->route('clinics.index')->with('flash_message', 'Clinic_added');
    }

    public function show($id)
    {
        $clinic = Facility::with('doctors')->findOrFail($id); // تغيير هنا
        return view('clinics.show')->with('clinic', $clinic);
    }

    public function trash()
    {
        $Clinics_deleted = Facility::onlyTrashed()->get(); // تغيير هنا
        return view('clinics.trash')->with('Clinics_deleted', $Clinics_deleted);
    }

    public function restore($id)
    {
        $Clinic = Facility::withTrashed()->findOrFail($id); // تغيير هنا
        $Clinic->restore();
        $Clinics = Facility::all(); // تغيير هنا
        return redirect()->back()->with('success', 'Clinic restored successfully.');
    }

    public function edit($id)
    {
        $Clinic = Facility::find($id); // تغيير هنا
        return view('clinics.edit')->with('Clinic', $Clinic);
    }

    public function update(Request $request, Facility $Clinic) // تغيير هنا
    {
        $input = $request->except('profile_pic');
        if ($request->hasFile('profile_pic')) {
            if ($Clinic->profile_pic) {
                $oldImagePath = public_path($Clinic->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('profile_pic');
            $file_path = $file->store('images', 'public');
            $input['profile_pic'] = '/storage/' .  $file_path;
        }
        $Clinic->update($input);
        $Clinics = Facility::all(); // تغيير هنا
        return redirect()->route('clinics.index')->with('Clinics', $Clinics)->with('flash_message', 'Clinic updated successfully!')->with('error_message', $error_message ?? null);
    }

    public function destroy($id)
    {
        $Clinic = Facility::find($id); // تغيير هنا
        $Clinic->delete();
        $Clinics = Facility::where('facility_type', 2)->with(['specializations', 'doctors'])->get(); // تغيير هنا
        return redirect()->route('clinics.index')->with('Clinics', $Clinics)->with('success', 'Clinic Trashed successfully.');
    }

    public function delete($id)
    {
        $Clinic = Facility::withTrashed()->find($id); // تغيير هنا
        $Clinic->forceDelete();
        $Clinics_deleted  = Facility::onlyTrashed()->get(); // تغيير هنا
        return redirect()->route('clinics.trash')->with('Clinics_deleted', $Clinics_deleted)->with('success', 'Clinic deleted successfully.');
    }

    //---------------------------------------------------------------------------------

    //-----------------------functions API----------------------------------------------------------

    public function index_api()
    {
        $Clinics = Facility::with(['specializations', 'doctors'])->get(); // تغيير هنا
        $specializations = Specialization::all();
        return response()->json([
            'success' => true,
            'message' => 'all Clinics',
            'Clinics' => $Clinics,
            'specializations' => $specializations
        ]);
    }

    public function store_api(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'Clinic_name' => 'required|string|max:255',
            'Clinic_address' => 'required|string|max:255',
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
        $Clinic = Facility::create($inputs); // تغيير هنا
        return response()->json([
            'success' => true,
            'message' => 'Clinics created successfully',
            'Clinics' => $Clinic
        ]);
    }

    public function show_api($id)
    {
        $Clinic = Facility::with(['doctors.specialization'])->findOrFail($id); // تغيير هنا
        if (is_null($Clinic)) {
            return response()->json([
                'fail' => false,
                'message' => 'sorry not found'
            ]);
        }

        $specializations = [];

        foreach ($Clinic->doctors as $doctor) {
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
            'message' => 'Clinics successfully retrieved',
            'Clinic' => [
                'id' => $Clinic->id,
                'name' => $Clinic->Clinic_name,
                'specializations' => array_values($specializations)
            ]
        ]);
    }

    public function update_api(Request $request, Facility $Clinic) // تغيير هنا
    {
        $input = $request->except('profile_pic');
        $validator = Validator::make($input, [
            'Clinic_name' => 'required|string|max:255',
            'Clinic_address' => 'required|string|max:255',
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
            if ($Clinic->profile_pic) {
                $oldImagePath = public_path($Clinic->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('profile_pic');
            $file_path = $file->store('images', 'public');
            $input['profile_pic'] = '/storage/' . $file_path;
        }
        $Clinic->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Clinic updated successfully',
            'Clinic' => $Clinic
        ]);
    }

    public function destroy_api($id)
    {
        $Clinic = Facility::find($id); // تغيير هنا
        $Clinic->delete();
        return response()->json([
            'success' => true,
            'message' => 'Clinic trashed successfully',
            'Clinic' => $Clinic
        ]);
    }

    public function delete_api($id)
    {
        $Clinic = Facility::withTrashed()->find($id); // تغيير هنا
        $Clinic->forceDelete();
        return response()->json([
            'success' => true,
            'message' => 'Clinic deleted successfully',
            'Clinic' => $Clinic
        ]);
    }

    public function restore_api($id)
    {
        $Clinic = Facility::withTrashed()->findOrFail($id); // تغيير هنا
        $Clinic->restore();
        return response()->json([
            'success' => true,
            'message' => 'Clinic restored successfully',
            'Clinic' => $Clinic
        ]);
    }

    //-------------------------------------------------------------------------------------------------------
}
