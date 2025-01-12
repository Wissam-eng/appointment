<?php

namespace App\Http\Controllers;

use App\Models\room_types;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{

    public function index()
    {
        $room_types = room_types::where('facility_id', session('facility_id'))->get();
        return view('rooms_type.index', compact('room_types'));
    }

    public function index_api(Request $request)
    {
       
        $room_types = room_types::where('facility_id',  $request->facility_id)->get();
        return response()->json($room_types);
    }


    public function test(Request $request)
    {
     
        $room_types = room_types::where('facility_id',  $request->facility_id)->with('room')->get();
        return response()->json($room_types);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms_type.create');
    }

    public function create_api()
    {
        return response()->json(['message' => 'API not applicable for create form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('storage/images', 'public');
            $data['profile_pic'] = $imagePath;
        }

        room_types::create($data);

        return redirect()->route('rooms_type.index')->with('success', 'Room type created successfully.');
    }

    public function store_api(Request $request)
    {
        $data = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('images', 'public');
            $data['profile_pic'] = 'storage/' . $imagePath;
        }

        $room_types =  room_types::create($data);
        return response()->json(['success' => true, 'data' => $room_types]);
    }


    public function edit($id)
    {
        $room_types = room_types::findOrFail($id);
        return view('rooms_type.edit', compact('room_types'));
    }



    public function update(Request $request,  $id)
    {

        $room_types = room_types::findOrFail($id);
        $data = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('images', 'public');
            $data['profile_pic'] = 'storage/' . $imagePath;
        }



        $room_types->update($data);
        return redirect()->route('rooms_type.index')->with('success', 'Room type updated successfully.');
    }

    public function update_api(Request $request,$id)
    {

      
        $room_types = room_types::find($id);
        if(!$room_types){
            return response()->json(['success' => false, 'message' => 'Room type not found.']);
        }

        

        $data = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('images', 'public');
            $data['profile_pic'] = 'storage/' . $imagePath;
        }

        $room_types->update($data);
        return response()->json(['success' => true, 'data' => $room_types]);
    }


    public function destroy( $id)
    {
        $room_types = room_types::findOrFail($id);
        $room_types->delete();
        return redirect()->route('rooms_type.index')->with('success', 'Room type moved to trash.');
    }

    public function destroy_api( $id)
    {

        $room_types = room_types::find($id);
        if($room_types){
            
        $room_types->delete();
        return response()->json(['success' => true, 'message' => 'Room type moved to trash.']);
        }else{
                    return response()->json(['success' => false, 'message' => 'Room type not found.']);

        }
    }


}
