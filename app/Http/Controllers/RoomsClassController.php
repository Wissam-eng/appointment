<?php

namespace App\Http\Controllers;

use App\Models\RoomsClass;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class RoomsClassController extends Controller
{





    public function __construct()
    {

        // Middleware for Web routes
        $this->middleware('auth');
        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
        $this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }



    // API Methods
    public function index_api(Request $request)
    {
        
        $facility_id = $request->facility_id;
       
       
        $roomsClass = RoomsClass::where('facility_id' , $facility_id)->get();
        
       
        return response()->json([
            'success' => true,
            'message' => 'RoomsClass retrieved successfully',
            'roomsClass' => $roomsClass
        ]);
    }


    public function store_api(Request $request)
    {
        $inputs = $request->validate([
            'roomsClass_name' => 'required|string|max:255',
            'price_day' => 'required|integer|max:255',
            'facility_id' => 'required|integer|max:255',
            'number_companions' => 'required|integer|max:255',
            'number_beds' => 'required|integer|max:255',
            'wifi' => 'required|in:0,1',
        ]);
        $roomClass = RoomsClass::create($inputs);
        return response()->json([
            'success' => true,
            'message' => 'RoomsClass created successfully',
            'roomClass' => $roomClass
        ]);
    }


    public function show_api($id)
    {
        $roomsClass = RoomsClass::find($id);
        if ($roomsClass) {
            return response()->json([
                'success' => true,
                'roomsClass' => $roomsClass
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'RoomsClass not found'], 404);
        }
    }


    public function update_api(Request $request, $id)
    {
        $roomsClass = RoomsClass::find($id);
        if (!$roomsClass) {
            return response()->json(['success' => false, 'message' => 'RoomsClass not found'], 404);
        }

        $inputs = $request->all();
        $roomsClass->update($inputs);

        return response()->json(['success' => true, 'message' => 'RoomsClass updated successfully']);
    }



    public function restore_api($id)
    {
        $room = RoomsClass::withTrashed()->find($id);
        if ($room) {
            $room->restore();
            return response()->json(['success' => true, 'message' => 'RoomsClass restored successfully']);
        }
        return response()->json(['success' => false, 'message' => 'RoomsClass not found'], 404);
    }

    // Resource Methods-------------------------------------------------------------------------------------------------------
    public function index()
    {
        if (Auth::user()->user_type == 2) {
            $roomsClass = RoomsClass::where('facility_id', session('facility_id'))->get();
        }else{
            
            $roomsClass = RoomsClass::all();
        }
        return view('roomsClass.index')->with('roomsClass', $roomsClass);
    }

    public function create()
    {
        return view('roomsClass.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        RoomsClass::create($inputs);
        return redirect()->route('roomsClass.index')->with('flash_message', 'Room added');
    }

    public function show($id)
    {
        $roomsClass = RoomsClass::find($id);
        return view('roomsClass.show')->with('roomsClass', $roomsClass);
    }

    public function edit($id)
    {
        $roomsClass = RoomsClass::find($id);
        return view('roomsClass.edit')->with('roomsClass', $roomsClass);
    }

    public function update(Request $request, $id)
    {

        $inputs = $request->all();
        $roomsClass = RoomsClass::find($id);
        $updated = $roomsClass->update($inputs);
        return redirect()->route('roomsClass.index')->with('flash_message', 'RoomsClass updated successfully!');
    }

    public function trash()
    {
        $roomsClassDeleted = RoomsClass::onlyTrashed()->get();
        return view('roomsClass.trash')->with('roomsClass_deleted', $roomsClassDeleted);
    }

    public function restore($id)
    {
        $room = RoomsClass::withTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('roomsClass.index')->with('flash_message', 'RoomsClass restored successfully');
    }

    public function delete($id)
    {
        $roomsClassDeleted = RoomsClass::withTrashed()->find($id);
        if ($roomsClassDeleted) {
            $roomsClassDeleted->forceDelete();
        }
        return redirect()->back()->with('success', 'RoomsClass deleted permanently.');
    }

    public function destroy($id)
    {
        $roomsClass = RoomsClass::find($id);
        if ($roomsClass) {
            $roomsClass->delete();
        }
        return redirect()->back();
    }
}
