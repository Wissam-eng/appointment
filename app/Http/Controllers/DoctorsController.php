<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use App\Models\Hospital;
use App\Models\specialization;
use App\Models\Clinic;
use App\Models\Facility;
use App\Models\Appointments;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoctorsController extends Controller
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
        $doctors = Doctors::where('Establishment_id', session('facility_id'))->with(['hospital', 'specialization', 'clinic'])->get();
       
        return view('doctors.index', compact('doctors'));
    }


    public function create()
    {
      
        $specializations = specialization::where('facility_id', session('facility_id'))->get();
     
        return view('doctors.create')->with([ 'specializations' => $specializations ]);
    }




    public function store(Request $request)
    {


        $requestData = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $file =  $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $requestData['profile_pic'] = '/storage/' . $path_file;
        }

        if ($request->has('work_days')) {
            $requestData['work_days'] = json_encode($request->work_days);
        }


        Doctors::create($requestData);

        return redirect('doctors')->with('flash_message', 'Doctor_added');
    }


    public function show( $id)
    {
   

        $doctors = Doctors::with(['hospital' , 'clinic', 'specialization'])->findOrFail($id);
        $workDays = json_decode($doctors->work_days);   
        return view('doctors.show', compact('doctors' , 'workDays'));
    }


    public function showDoctors($id)
    {
        $doctors = Doctors::where('Establishment_id', $id)->get();


        return view('doctors.index', compact('doctors'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hospitals = hospital::all();
        $specialization = specialization::all();
        $clinics = Clinic::all();
        $doctors = Doctors::with('hospital')->findOrFail($id);
        $workDays = $doctors->work_days ? json_decode($doctors->work_days, true) : [];
        return view('doctors.edit', compact('doctors', 'hospitals', 'specialization' ,'clinics','workDays'));
    }

    /**
     * Update the specified resource in storage.
     */







    public function update(Request $request, Doctors $doctor)
    {
        $inputs = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            if ($doctor->profile_pic) {
                $oldImagePath = public_path($doctor->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('profile_pic');
            $filePath = $file->store('images', 'public');
            $inputs['profile_pic'] = '/storage/' . $filePath;
        }

        $updated = $doctor->update($inputs);

        if ($updated) {
            return redirect()->route('doctors.index')->with('flash_message', 'Doctor updated successfully!');
        } else {
            return redirect()->back()->with('flash_message', 'Doctor update failed, no rows affected.');
        }
    }






    public function trash()
    {
        $doctor_deleted = Doctors::where('Establishment_id' , session('facility_id'))->onlyTrashed()->with(['hospital', 'specialization'])->get();
        // $doctor_deleted = Doctors::onlyTrashed()->with('specialization')->get();

        return view('doctors.trash')->with('doctor_deleted', $doctor_deleted);
    }







    public function restore($id)
    {
        $doctor = Doctors::withTrashed()->findOrFail($id);
        $doctor->restore();

        return redirect()->route('doctors.index')->with('success', 'Doctor restored successfully.');
    }





    public function delete($id)
    {


        $doctor = Doctors::withTrashed()->find($id);
        if ($doctor) {
            $doctor->forceDelete();
        }
        return redirect()->back()->with('success', 'Doctor deleted permanently.');
    }




    public function destroy($id)
    {

        $doctor = Doctors::find($id);
        if ($doctor) {
            $doctor->delete();
        }
        return redirect()->back();
    }









        // API Method to store a new doctor

        public function index_api(Request $request)
        {

            $doctors = Doctors::where('Establishment_id' , $request->facility_id )->with(['hospital', 'specialization', 'clinic'])->get();
            $specialization = Specialization::where('facility_id' , $request->facility_id )->get();
            return response()->json([
                'success' => true,
                'doctors' => $doctors,
                'specialization' => $specialization,
            ]);
        }
    



        public function store_api(Request $request)
        {
            $requestData = $request->except('profile_pic');
    
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $path_file = $file->store('images', 'public');
                $requestData['profile_pic'] = '/storage/' . $path_file;
            }
    
            $doctor = Doctors::create($requestData);
    
            return response()->json([
                'success' => true,
                'message' => 'Doctor added successfully',
                'doctor' => $doctor,
            ]);
        }
    
        // API Method to show a specific doctor
        public function show_api(Request $request ,$id)
        {
            $facilitty_id = $request->facility_id;

            // $doctor = Appointments::select('id' , 'booking_type' ,'analysis_id', 'created_at' ,'start_date' , 'end_date' , 'room_id' , 'old_child' , 'surgery_type' , 'user_id' , 'doctor'  )->with([
            //     'user' => function ($query) {
            //         $query->select('id', 'first_name', 'last_name', 'mobile'); // Include 'id' column
            //     },
    
            //     'analyses' => function ($query) {
            //         $query->select('id' ,'analysis_name' ,'analysis_pic' ); // Include 'id' column
                    
            //     },
            //     'surgery_type' => function ($query) {
            //         $query->select('id' ,'operation_name' ,'specialization_id','operation_pic' ); // Include 'id' column
                    
            //     },
            //     'surgery_type.specialization' => function ($query) {
            //         $query->select('id' ,'specialization_name'  ); // Include 'id' column
                    
            //     },
    
            //     'room' => function ($query) {
            //         $query->select('id' , 'room_type' , 'room_class' ); // Include 'id' column
                    
            //     },
            //     'room.roomType' => function ($query) {
            //         $query->select('id' , 'room_type_name'); // Include 'id' column
                    
            //     },
            //     'room.roomClass' => function ($query) {
            //         $query->select('id' , 'roomsClass_name' ); // Include 'id' column
                    
            //     },
            //     'doctor' => function ($query) {
            //         $query->select('id' , 'first_name' , 'last_name' , 'specialization_id' , 'gender' , 'profile_pic'); // Include 'id' column
                    
            //     },
            //     'doctor.specialization' => function ($query) {
            //         $query->select('id', 'specialization_name'); // Select specialization details
            //     }
            // ])->where('doctor', $id)->get();

            $doctor = Doctors::with(['hospital', 'clinic', 'specialization' , 
            'appointments' ,

            'appointments.analyses' => function ($query) {
                $query->select('id' ,'analysis_name' ,'analysis_pic' ); // Include 'id' column
                
            },
            'appointments.user' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'mobile'); // Include 'id' column
            },
            'appointments.operation' => function ($query) {
                $query->select('id' ,'operation_name' ,'specialization_id','operation_pic' ); // Include 'id' column
                
            },

            
            ])->where('Establishment_id', $facilitty_id)->find($id);
    
            if ($doctor) {
                return response()->json([
                    'success' => true,
                    'doctor' => $doctor,
                ]);
            }
    
            return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
        }
    
        // API Method to update a specific doctor
        public function update_api(Request $request, $id)
        {
            $doctor = Doctors::find($id);
            if (!$doctor) {
                return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
            }
    
            $inputs = $request->except('profile_pic');
    
            if ($request->hasFile('profile_pic')) {
                if ($doctor->profile_pic) {
                    $oldImagePath = public_path($doctor->profile_pic);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $file = $request->file('profile_pic');
                $filePath = $file->store('images', 'public');
                $inputs['profile_pic'] = '/storage/' . $filePath;
            }
    
            $doctor->update($inputs);
    
            return response()->json(['success' => true, 'message' => 'Doctor updated successfully']);
        }



        public function trash_api(request $request)
        {
            $user = Auth::user();

            $Doctors_deleted = Doctors::onlyTrashed()->where('Establishment_id' , $user->id)->get();
            return response()->json(['success' => true, 'Doctors_deleted' => $Doctors_deleted]);
        }
    
        // API Method to delete a specific doctor
        public function destroy_api($id)
        {
            $doctor = Doctors::find($id);
            if ($doctor) {
                $doctor->delete();
                return response()->json(['success' => true, 'message' => 'Doctor deleted successfully']);
            }
    
            return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
        }

        
    
        // API Method to restore a deleted doctor
        public function restore_api($id)
        {
            $doctor = Doctors::withTrashed()->find($id);
            if ($doctor) {
                $doctor->restore();
                return response()->json(['success' => true, 'message' => 'Doctor restored successfully']);
            }
    
            return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
        }
}
