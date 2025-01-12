<?php

namespace App\Http\Controllers;

use App\Models\specialization;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SpecializationController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 2) {
            $specializations = specialization::where('facility_id', session('facility_id'))->get();
            
        } else {
            
            $specializations = specialization::all();
        }
        return view('specializations.index')->with('specializations', $specializations);
    }

    public function index_api(request $request)
    {
      
        if (Auth::user()->user_type == 2) {
            $specializations = specialization::where('facility_id', $request->facility_id)->get();
        } elseif (Auth::user()->user_type == 1) {
            $specializations = Specialization::all();
        }
        return response()->json([
            'success' => true,
            'message' => 'specializations retrieved successfully',
            'specializations' => $specializations
        ]);
    }

    public function create()
    {
        return view('specializations.create');
    }

    public function store(Request $request)
    {

        $inputs = $request->except('specialization_pic');

        if ($request->hasFile('specialization_pic')) {
            $file = $request->file('specialization_pic');
            $path_file = $file->store('images', 'public');
            $inputs['specialization_pic'] = '/storage/' . $path_file;
        }

        Specialization::create($inputs);
        return redirect()->back()->with('flash_message', 'Specialization added');
    }

    public function show(Specialization $specialization)
    {
        return view('specializations.show')->with('specialization', $specialization);
    }

    public function edit(Specialization $specialization)
    {
        return view('specializations.edit')->with('specialization', $specialization);
    }

    public function update(Request $request, Specialization $specialization)
    {
        $inputs = $request->except('specialization_pic');

        if ($request->hasFile('specialization_pic')) {
            if ($specialization->specialization_pic) {
                $old_image_path = public_path($specialization->specialization_pic);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file = $request->file('specialization_pic');
            $path_file = $file->store('images', 'public');
            $inputs['specialization_pic'] = '/storage/' . $path_file;
        }

        $specialization->update($inputs);
        $specializations = specialization::all();
        return view('specializations.index')->with('specializations', $specializations);
    }

    public function trash()
    {
        $specializations_deleted = specialization::onlyTrashed()->get();
        return view('specializations.trash')->with('specializations_deleted', $specializations_deleted);
    }

    public function restore($id)
    {
        $specialization = specialization::withTrashed()->findOrFail($id);
        $specialization->restore();
        return redirect()->route('specializations.index')->with('success', 'Specialization restored successfully.');
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();
        $specializations = specialization::all();
        return view('specializations.index')->with('specializations', $specializations);
    }

    public function delete($id)
    {

        $specialization = specialization::withTrashed()->find($id);
        if ($specialization) {
            $specialization->forceDelete();
        }
        $specializations_deleted = Specialization::onlyTrashed();
        return view('specializations.trash')->with('specializations_deleted', $specializations_deleted);
    }



    public function store_api(Request $request)
    {
        $inputs = $request->except('specialization_pic');

        if ($request->hasFile('specialization_pic')) {
            $file = $request->file('specialization_pic');
            $path_file = $file->store('images', 'public');
            $inputs['specialization_pic'] = '/storage/' . $path_file;
        }

        $specialization =  specialization::create($inputs);
        return response()->json([
            'success' => true,
            'message' => 'Specialization added successfully',
            'specialization' => $specialization
        ]);
    }

    public function show_api($id)
    {
        $specialization = specialization::find($id);
        if ($specialization) {
            return response()->json([
                'success' => true,
                'specialization' => $specialization
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Specialization not found'], 404);
    }

    public function update_api(Request $request, $id)
    {
        $specialization = specialization::find($id);
        if (!$specialization) {
            return response()->json(['success' => false, 'message' => 'Specialization not found'], 404);
        }

        $inputs = $request->except('specialization_pic');

        if ($request->hasFile('specialization_pic')) {
            if ($specialization->specialization_pic) {
                $old_image_path = public_path($specialization->specialization_pic);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file = $request->file('specialization_pic');
            $path_file = $file->store('images', 'public');
            $inputs['specialization_pic'] = '/storage/' . $path_file;
        }

        $specialization->update($inputs);
        return response()->json(['success' => true, 'message' => 'Specialization updated successfully' , 'specialization' => $specialization]);
    }



    public function destroy_api($id)
    {
        // return response()->json(['success' => true, 'message' => 'Specialization deleted successfully']);

        $specialization = specialization::find($id);
        if ($specialization) {
            $specialization->delete();
            return response()->json(['success' => true, 'message' => 'Specialization deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Specialization not found'], 404);
    }




    public function trash_api()
    {
        $specializations_deleted = specialization::onlyTrashed()->get();
        return response()->json(['success' => true, 'specializations_deleted' => $specializations_deleted]);
    }

    public function restore_api($id)
    {
        $specialization = specialization::withTrashed()->find($id);
        if ($specialization) {
            $specialization->restore();
            return response()->json(['success' => true, 'message' => 'Specialization restored successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Specialization not found'], 404);
    }

    public function delete_api($id)
    {
        $specialization = specialization::withTrashed()->find($id);
        if ($specialization) {
            $specialization->forceDelete();
            return response()->json(['success' => true, 'message' => 'Specialization deleted permanently']);
        }
        return response()->json(['success' => false, 'message' => 'Specialization not found'], 404);
    }
}
