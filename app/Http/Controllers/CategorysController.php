<?php

namespace App\Http\Controllers;

use App\Models\categorys;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CategorysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->user_type == 2) {
            $categories = categorys::where('facility_id', session('facility_id'))->get();
        } else {

            $categories = categorys::all();
        }
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     
       
        $inputs = $request->except('img');

        if ($request->hasFile('img')) {
            $file =  $request->file('img');
            $path_file = $file->store('images/categories', 'public');
            $inputs['img'] = '/storage/' . $path_file;
        }

        try {
            Categorys::create($inputs);
           
            return redirect()->route('categories.index')->with(['success' => 'Category created successfully.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the category.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorys $categorys)
    {
        return view('categories.show', compact('categorys'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($categorys)
    {
        $categorys = Categorys::find($categorys);
        return view('categories.edit', compact('categorys'));
    }

    /**
     * Update the specified resource in storage.
     */ public function update(Request $request, Categorys $category)
    {


        $inputs = $request->except('img');

        if ($request->hasFile('img')) {
            // Check if there is an existing profile picture
            if ($category->profile_pic) {
                $oldImagePath = public_path($category->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Remove the old image if it exists
                }
            }

            // Store the new image
            $file = $request->file('img');
            $filePath = $file->store('images/categories', 'public');
            $inputs['img'] = '/storage/' . $filePath; // Assign the new image path
        }

        // Update the category with the new inputs
        $updated = $category->update($inputs);

        if ($updated) {
            return redirect()->route('categories.index')->with('flash_message', 'Category updated successfully!');
        } else {
            return redirect()->back()->with('flash_message', 'Category update failed, no rows affected.');
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorys $categorys)
    {
        $categorys->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }





    public function index_api(Request $request)
    {
        $facility_id = $request->facility_id;
        $categories = Categorys::where('facility_id', $facility_id)->get();
        return response()->json(['success' => true, 'data' => $categories], 200);
    }

    /**
     * Store a newly created resource in storage via API.
     */
    public function store_api(Request $request)
    {
        $inputs = $request->except('img');

        if ($request->hasFile('img')) {
            $file =  $request->file('img');
            $path_file = $file->store('images/categories', 'public');
            $inputs['img'] = '/storage/' . $path_file;
        }

        $category = Categorys::create($inputs);

        return response()->json(['success' => true, 'message' => 'Category created successfully', 'data' => $category], 201);
    }

    /**
     * Display the specified resource via API.
     */
    public function show_api($id)
    {
        $category = Categorys::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $category], 200);
    }

    /**
     * Update the specified resource in storage via API.
     */
    public function update_api(Request $request, $id)
    {

        $category = Categorys::find($id);
        $inputs = $request->except('img');

        if ($request->hasFile('img')) {
            // Check if there is an existing profile picture
            if ($category->profile_pic) {
                $oldImagePath = public_path($category->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Remove the old image if it exists
                }
            }

            // Store the new image
            $file = $request->file('img');
            $filePath = $file->store('images/categories', 'public');
            $inputs['img'] = '/storage/' . $filePath; // Assign the new image path
        }
        $category->update($inputs);

        return response()->json(['success' => true, 'message' => 'Category updated successfully', 'data' => $category], 200);
    }

    /**
     * Remove the specified resource from storage via API.
     */
    public function destroy_api($id)
    {
        $category = Categorys::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully'], 200);
    }
}
