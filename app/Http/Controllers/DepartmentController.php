<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function index_api()
    {
        $departments = Department::all();
        return response()->json([
            'success' => true,
            'message' => 'Departments retrieved successfully',
            'departments' => $departments
        ]);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'dep_name' => 'required|string|max:255',
        ]);
        Department::create($inputs);
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function store_api(Request $request)
    {
        $inputs = $request->validate([
            'dep_name' => 'required|string|max:255',
        ]);
        $department = Department::create($inputs);
        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'department' => $department
        ]);
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function show_api($id)
    {
        $department = Department::findOrFail($id);
        return response()->json([
            'success' => true,
            'department' => $department
        ]);
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $inputs = $request->validate([
            'dep_name' => 'required|string|max:255',
        ]);
        $department->update($inputs);
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function update_api(Request $request, $id)
    {
        $inputs = $request->validate([
            'dep_name' => 'required|string|max:255',
        ]);
        $department = Department::findOrFail($id);
        $department->update($inputs);
        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully',
            'department' => $department
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function destroy_api($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully'
        ]);
    }

    // Restore functionality for web
    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();

        return redirect()->route('departments.index')->with('success', 'Department restored successfully.');
    }

    // API: Restore functionality for soft-deleted department
    public function restore_api($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();

        return response()->json([
            'success' => true,
            'message' => 'Department restored successfully',
            'department' => $department
        ]);
    }



    public function trash_api()
    {
        $employees_deleted = Department::onlyTrashed()->get();
        return response()->json([
            'success' => true,
            'message' => 'Deleted Department retrieved successfully',
            'employees_deleted' => $employees_deleted
        ]);
    }

    // Web: Permanently delete (force delete)
    public function delete($id)
    {
        $department = Department::withTrashed()->find($id);
        if ($department) {
            $department->forceDelete();
        }
        return redirect()->back()->with('success', 'Department deleted permanently.');
    }

    // API: Permanently delete (force delete)
    public function delete_api($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted permanently'
        ]);
    }
}
