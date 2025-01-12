<?php

namespace App\Http\Controllers;

use App\Models\profile;
use App\Models\Hospital;
use App\Models\specialization;
use App\Models\Clinic;
use App\Models\Facility;
use App\Models\User;
use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
        $profile = profile::all();

        return view('profile.index', compact('profile'));
    }



    public function myprofile($id)
    {
        $profile = profile::where('user_id', $id)->get();

        return view('profile.index', compact('profile'));
    }


    public function create()
    {

        $facilities = Facility::all();

        return view('profile.create')->with('facilities', $facilities);
    }




    public function store(Request $request)
    {
        $profileData = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $profileData['profile_pic'] = '/storage/' . $path_file;
        }

        $user = User::create([
            'user_type' => $request->user_type,
            'name' => $request->first_name,
            'email' => $request->email,
            'facility_id' => $request->facility_id,
            'password' => Hash::make($request->password),
        ]);

        $profileData['user_id'] = $user->id;

       $profile =  profile::create($profileData);

        if ($profile) {
            $facility = Facility::find($request->facility_id);
            if ($facility) {
                $facility->update([
                    'manager_id' => $user->id
                ]);
            }
           
        }

        return redirect('profile')->with('flash_message', __('user added successfully'));
    }




    public function show($id)
    {


        $profile = profile::find($id);

        return view('profile.show', compact('profile'));
    }


    // public function showprofile($id)
    // {
    //     $profile = profile::where('Establishment_id', $id)->get();


    //     return view('profile.index', compact('profile'));
    // }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $profile = Profile::with('user')->find($id);

        $facilities = Facility::all();

        if (!$profile) {
            return redirect()->route('profile.index')->with('error', 'Profile not found.');
        }

        return view('profile.edit', compact('profile' , 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */







    public function update(Request $request, profile $doctor)
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
        $doctor->user->update([
            'facility_id' => $request->facility_id
        ]);

        if ($request->has('email') || $request->has('password')) {
            $user = $doctor->user;
            if ($user) {
                if ($request->has('email')) {
                    $user->email = $request->email;
                }
                if ($request->has('password')) {
                    $user->password = bcrypt($request->password);
                }
                $user->save();
            }
        }

        
        if ($doctor) {
            $facility = Facility::find($request->facility_id);
           
            if ($facility) {
                $facility->update([
                    'manager_id' => $user->id
                ]);
            }
           
        }



        if ($doctor->wasChanged() || ($user && $user->wasChanged())) {

            if ($doctor->user->user_type == 1) {
              
                $profile = profile::all();
            }else {
                
                $profile = profile::where('user_id', $doctor->user_id)->get();
            }

            return view('profile.index', compact('profile'))->with('flash_message', 'Doctor updated successfully!');
        } else {
            return redirect()->back()->with('flash_message', 'Doctor update failed, no rows affected.');
        }
    }






    public function trash()
    {
        $profile_deleted = profile::onlyTrashed()->get();

        return view('profile.trash')->with('doctor_deleted', $profile_deleted);
    }







    public function restore($id)
    {
        $profile = profile::withTrashed()->findOrFail($id);
        $profile->restore();

        return redirect()->route('profile.index')->with('success', 'Doctor restored successfully.');
    }





    public function delete($id)
    {


        $profile = profile::withTrashed()->find($id);
        $user = user::withTrashed()->find($profile->user_id);
        if ($profile && $user) {
            $user->forceDelete();
            $profile->forceDelete();
        }
        return redirect()->back()->with('success', 'Doctor deleted permanently.');
    }




    public function destroy($id)
    {

        $profile = profile::find($id);
        $user = user::withTrashed()->find($profile->user_id);
        if ($profile && $user) {
            $user->delete();
            $profile->delete();
        }
        return redirect()->back();
    }









    // API Method to store a new doctor

    public function index_api()
    {
        $profiles = profile::all();
        return response()->json([
            'success' => true,
            'profiles' => $profiles,
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

        $doctor = profile::create($requestData);

        return response()->json([
            'success' => true,
            'message' => 'profile added successfully',
            'doctor' => $doctor,
        ]);
    }

    // API Method to show a specific doctor
    public function show_api($id)
    {
        $profile = profile::where('user_id', $id)->get();

        if ($profile) {
            return response()->json([
                'success' => true,
                'profile' => $profile,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'profile not found'], 404);
    }

    // API Method to update a specific doctor
    public function update_api(Request $request, $id)
    {
        $doctor = profile::where('user_id', $id)->first();
        if (!$doctor) {
            return response()->json(['success' => false, 'message' => 'profile not found'], 404);
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

        return response()->json(['success' => true, 'message' => 'profile updated successfully']);
    }



    public function trash_api()
    {
        $profile_deleted = profile::onlyTrashed()->get();
        return response()->json(['success' => true, 'profile_deleted' => $profile_deleted]);
    }

    // API Method to delete a specific doctor
    public function destroy_api($id)
    {
        $profile = profile::find($id);
        if ($profile) {
            $profile->delete();
            return response()->json(['success' => true, 'message' => 'profile deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'profile not found'], 404);
    }

    // API Method to restore a deleted doctor
    public function restore_api($id)
    {
        $profile = profile::withTrashed()->find($id);
        if ($profile) {
            $profile->restore();
            return response()->json(['success' => true, 'message' => 'profile restored successfully']);
        }

        return response()->json(['success' => false, 'message' => 'profile not found'], 404);
    }
}
