<?php

namespace App\Http\Controllers;

use App\Models\rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function store(Request $request)
    {

        // Create a new rate record
        $rate = Rate::create($request);

        // Return a success response
        return redirect()->route('doctors.index')->with('flash_message', 'Doctor rated successfully.');
    }


    public function store_api(Request $request)
    {
        // Create a new rate record
        $rate = Rate::create($request->all());
    
        // Return a success response
        return response()->json([
            'message' => 'Rating created successfully',
            'rate' => $rate,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rate $rate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rate $rate)
    {
        //
    }
}
