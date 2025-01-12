<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
       
        $employees = Employee::where('Establishment_id' , session('facility_id'))->get();
      
        return view('employees.index', compact('employees'));
    }



    public function index_api()
    {
        $employees = Employee::all();
        return response()->json([
            'success' => true,
            'message' => 'Employees retrieved successfully',
            'employees' => $employees
        ]);
    }

    public function create()
    {
        return view('employees.create');
    }



    public function store(Request $request)
    {
   
        $requestData = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $requestData['profile_pic'] = '/storage/' . $path_file;
        }

        Employee::create($requestData);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function store_api(Request $request)
    {
        $requestData = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $requestData['profile_pic'] = '/storage/' . $path_file;
        }

        $employee = Employee::create($requestData);

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'employee' => $employee
        ]);
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function show_api(Employee $employee)
    {
        return response()->json([
            'success' => true,
            'message' => 'Employee retrieved successfully',
            'employee' => $employee
        ]);
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $requestData = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $requestData['profile_pic'] = '/storage/' . $path_file;
        }

        $employee->update($requestData);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function update_api(Request $request, Employee $employee)
    {
        $requestData = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $path_file = $file->store('images', 'public');
            $requestData['profile_pic'] = '/storage/' . $path_file;
        }

        $employee->update($requestData);

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully',
            'employee' => $employee
        ]);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function destroy_api($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();
            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'not found Employee'
            ]);
        }
    }

    public function trash()
    {
        $employees_deleted = Employee::onlyTrashed()->get();
        return view('employees.trash', compact('employees_deleted'));
    }

    public function trash_api()
    {
        $employees_deleted = Employee::onlyTrashed()->get();
        return response()->json([
            'success' => true,
            'message' => 'Deleted employees retrieved successfully',
            'employees_deleted' => $employees_deleted
        ]);
    }

    public function restore($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->restore();

        return redirect()->route('employees.index')->with('success', 'Employee restored successfully.');
    }

    public function restore_api($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->restore();

        return response()->json([
            'success' => true,
            'message' => 'Employee restored successfully',
            'employee' => $employee
        ]);
    }

    public function delete($id)
    {
        $employee = Employee::withTrashed()->find($id);
        if ($employee) {
            $employee->forceDelete();
        }
        return redirect()->back()->with('success', 'Employee deleted permanently.');
    }

    public function delete_api($id)
    {
        $employee = Employee::withTrashed()->find($id);
        if ($employee) {
            $employee->forceDelete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Employee deleted permanently'
        ]);
    }
}
