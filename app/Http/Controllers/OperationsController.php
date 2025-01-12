<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\operations;
use App\Models\specialization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class operationsController extends Controller
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
            $operations = operations::where('facility_id', session('facility_id'))->get();
        }else{
            
            $operations = operations::all();
        }
        return view('operations.index')->with('operations', $operations);
    }

    public function index_api(Request $request)
    {
       
        $operations = operations::where('facility_id', $request->facility_id)->get();
        return response()->json([
            'success' => true,
            'message' => 'operationss retrieved successfully',
            'operations' => $operations
        ]);
    }

    public function create()
    {
        $facilities = Facility::all();
        $facility_id = session('facility_id');
        $specialization = Specialization::where('facility_id', $facility_id)->get();
        return view('operations.create')->with(['facilities'=> $facilities , 'specialization'=> $specialization]);
    }

    public function store(Request $request)
    {
       
        $inputs = $request->except('operation_pic');

        if ($request->hasFile('operation_pic')) {
            $file = $request->file('operation_pic');
            $path_file = $file->store('images', 'public');
            $inputs['operation_pic'] = '/storage/' . $path_file;
        }

        operations::create($inputs);
        return redirect()->route('operations.index')->with('flash_message', 'operations added');
    }

    public function show(operations $operation)
    {
        return view('operations.show')->with('operation', $operation);
    }

    public function edit($id)
    {
        $facility_id = session('facility_id');
        $specialization = Specialization::where('facility_id', $facility_id)->get();
        $operations = operations::find($id);
        return view('operations.edit')->with(['operations'=> $operations, 'specialization' => $specialization]);
    }

    public function update(Request $request, $id)
    {
        
        $operation = operations::find($id);
        $inputs = $request->except('operation_pic');

        if ($request->hasFile('operation_pic')) {
            if ($operation->operation_pic) {
                $old_image_path = public_path($operation->operation_pic);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file = $request->file('operation_pic');
            $path_file = $file->store('images', 'public');
            $inputs['operation_pic'] = '/storage/' . $path_file;
        }

        $operation->update($inputs);
        return redirect()->route('operations.index')->with('operations', operations::all());
    }

    public function trash()
    {
        $operations_deleted = operations::onlyTrashed()->get();
        return view('operations.trash')->with('operations_deleted', $operations_deleted);
    }

    public function restore($id)
    {
        $operation = operations::withTrashed()->find($id);
        if ($operation) {
            $operation->restore();
            return redirect()->route('operations.index')->with('success', 'operations restored successfully.');
        } else {
            return redirect()->route('operations.index')->with('error', 'operations not found.');
        }
    }

    public function destroy($id)
    {
        $operation = operations::find($id);
        if ($operation) {
            $operation->delete();
        }
        return redirect()->route('operations.index')->with('operations', operations::all());
    }

    public function delete($id)
    {
        $operation = operations::withTrashed()->find($id);
        if ($operation) {
            $operation->forceDelete();
        }
        return redirect()->route('operations.trash')->with('operations_deleted', operations::onlyTrashed());
    }

    public function store_api(Request $request)
    {
        $inputs = $request->except('operation_pic');

        if ($request->hasFile('operation_pic')) {
            $file = $request->file('operation_pic');
            $path_file = $file->store('images', 'public');
            $inputs['operation_pic'] = '/storage/' . $path_file;
        }

        $operation = operations::create($inputs);
        return response()->json([
            'success' => true,
            'message' => 'operations added successfully',
            'operation' => $operation
        ]);
    }

    public function show_api($id)
    {
        $operation = operations::find($id);
        if ($operation) {
            return response()->json([
                'success' => true,
                'operation' => $operation
            ]);
        }
        return response()->json(['success' => false, 'message' => 'operations not found'], 404);
    }

    public function update_api(Request $request, $id)
    {
        $operation = operations::find($id);
        if (!$operation) {
            return response()->json(['success' => false, 'message' => 'operations not found'], 404);
        }

        $inputs = $request->except('operation_pic');

        if ($request->hasFile('operation_pic')) {
            if ($operation->operation_pic) {
                $old_image_path = public_path($operation->operation_pic);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file = $request->file('operation_pic');
            $path_file = $file->store('images', 'public');
            $inputs['operation_pic'] = '/storage/' . $path_file;
        }

        $operation->update($inputs);
        return response()->json(['success' => true, 'message' => 'operations updated successfully']);
    }

    public function destroy_api($id)
    {
        $operation = operations::find($id);
        if ($operation) {
            $operation->delete();
            return response()->json(['success' => true, 'message' => 'operations deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'operations not found'], 404);
    }

    public function trash_api()
    {
        $operations_deleted = operations::onlyTrashed()->get();
        return response()->json(['success' => true, 'operations_deleted' => $operations_deleted]);
    }

    public function restore_api($id)
    {
        $operation = operations::withTrashed()->find($id);
        if ($operation) {
            $operation->restore();
            return response()->json(['success' => true, 'message' => 'operations restored successfully']);
        }
        return response()->json(['success' => false, 'message' => 'operations not found'], 404);
    }

    public function delete_api($id)
    {
        $operation = operations::withTrashed()->find($id);
        if ($operation) {
            $operation->forceDelete();
            return response()->json(['success' => true, 'message' => 'operations deleted permanently']);
        }
        return response()->json(['success' => false, 'message' => 'operations not found'], 404);
    }
}
