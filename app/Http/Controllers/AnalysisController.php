<?php

namespace App\Http\Controllers;


use App\Models\Facility;

use App\Models\analysis;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
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
        if (Auth::user()->user_type == 2) {
            $analysis = analysis::where('facility_id', session('facility_id'))->get();
        } else {
            
            $analysis = analysis::all();
        }

        
        return view('analysis.index')->with('analysis', $analysis);
    }



    public function index_api(Request $request)
    {
        
      
        
        $analysis = analysis::where('facility_id', $request->facility_id)->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Analyses retrieved successfully',
            'analysis' => $analysis
        ]);
    }

    public function create()
    {
        $Facilies = Facility::all();
        return view('analysis.create')->with('Facilies', $Facilies);
    }

    public function store(Request $request)
    {
        $inputs = $request->except('analysis_pic');

        if ($request->hasFile('analysis_pic')) {
            $file = $request->file('analysis_pic');
            $path_file = $file->store('images', 'public');
            $inputs['analysis_pic'] = '/storage/' . $path_file;
        }

        analysis::create($inputs);
        return redirect()->route('analysis.index')->with('flash_message', 'analysis added');
    }

    public function show(analysis $analysis)
    {
        return view('analysis.show')->with('analysis', $analysis);
    }

    public function edit($id)
    {
        $analysis = analysis::find($id);
        return view('analysis.edit')->with('analysis', $analysis);
    }


    public function update(Request $request, $id)
    {
        $analysis = analysis::find($id);
        $inputs = $request->except('analysis_pic');


        if ($request->hasFile('analysis_pic')) {
            if ($analysis->analysis_pic) {
                $old_image_path = public_path($analysis->analysis_pic);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file = $request->file('analysis_pic');
            $path_file = $file->store('images', 'public');
            $inputs['analysis_pic'] = '/storage/' . $path_file;
        }

        $analysis->update($inputs);
      
        return redirect()->route('analysis.index');
    }




    public function trash()
    {
        $analysis_deleted = analysis::onlyTrashed()->get();
        return view('analysis.trash')->with('analysis_deleted', $analysis_deleted);
    }




    public function restore($id)
    {
        $analysis = analysis::withTrashed()->find($id);  // Use find() instead of findOrFail() for custom error handling
        if ($analysis) {
            $analysis->restore();
            return redirect()->route('analysis.index')->with('success', 'Analysis restored successfully.');
        } else {
            return redirect()->route('analysis.index')->with('error', 'Analysis not found.');
        }
    }
    




    public function destroy($id)
    {
        $analysis = analysis::find($id);
        if ($analysis) {
            $analysis->delete();
        }
        $analysis = analysis::all();
        return view('analysis.index')->with('analysis', $analysis);
    }
    







    public function delete($id)
    {
        $analysis = analysis::withTrashed()->find($id);
        if ($analysis) {
            $analysis->forceDelete();
        }
        $analysis_deleted = analysis::onlyTrashed();
        return view('analysis.trash')->with('analysis_deleted', $analysis_deleted);
    }







    public function store_api(Request $request)
    {
        // dd($request->all());
        $inputs = $request->except('analysis_pic');

        if ($request->hasFile('analysis_pic')) {
            $file = $request->file('analysis_pic');
            $path_file = $file->store('images', 'public');
            $inputs['analysis_pic'] = '/storage/' . $path_file;
        }

        $analysis = analysis::create($inputs);
        return response()->json([
            'success' => true,
            'message' => 'analysis added successfully',
            'analysis' => $analysis
        ]);
    }

    public function show_api($id)
    {
        $analysis = analysis::find($id);
        if ($analysis) {
            return response()->json([
                'success' => true,
                'analysis' => $analysis
            ]);
        }
        return response()->json(['success' => false, 'message' => 'analysis not found'], 404);
    }

    public function update_api(Request $request, $id)
    {
        $analysis = analysis::find($id);
        if (!$analysis) {
            return response()->json(['success' => false, 'message' => 'analysis not found'], 404);
        }

        $inputs = $request->except('analysis_pic');

        if ($request->hasFile('analysis_pic')) {
            if ($analysis->analysis_pic) {
                $old_image_path = public_path($analysis->analysis_pic);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file = $request->file('analysis_pic');
            $path_file = $file->store('images', 'public');
            $inputs['analysis_pic'] = '/storage/' . $path_file;
        }

        $analysis->update($inputs);
        return response()->json(['success' => true, 'message' => 'analysis updated successfully']);
    }

    public function destroy_api($id)
    {
        $analysis = analysis::find($id);
        if ($analysis) {
            $analysis->delete();
            return response()->json(['success' => true, 'message' => 'analysis deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'analysis not found'], 404);
    }

    public function trash_api()
    {
        $analysis_deleted = analysis::onlyTrashed()->get();
        return response()->json(['success' => true, 'analysis_deleted' => $analysis_deleted]);
    }

    public function restore_api($id)
    {
        $analysis = analysis::withTrashed()->find($id);
        if ($analysis) {
            $analysis->restore();
            return response()->json(['success' => true, 'message' => 'analysis restored successfully']);
        }
        return response()->json(['success' => false, 'message' => 'analysis not found'], 404);
    }

    public function delete_api($id)
    {
        $analysis = analysis::withTrashed()->find($id);
        if ($analysis) {
            $analysis->forceDelete();
            return response()->json(['success' => true, 'message' => 'analysis deleted permanently']);
        }
        return response()->json(['success' => false, 'message' => 'analysis not found'], 404);
    }
}
