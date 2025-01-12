<?php

namespace App\Http\Controllers;

use App\Models\room;
use App\Models\hospital;
use App\Models\RoomsClass;
use App\Models\Clinic;
use App\Models\room_types;
use App\Models\facility;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
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
        $rooms = room::where('facility_id', $request->facility_id)->with(['hospital', 'roomClass', 'clinic', 'roomType'])->get();
        $roomType = room_types::all();
        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully',
            'rooms' => $rooms,
            'roomType' => $roomType
        ]);
    }


    public function room_type_api(Request $request)
    {
        $roomType = room_types::all();
        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully',

            'roomType' => $roomType
        ]);
    }

    public function store_api(Request $request)
    {
        
       
        $inputs = $request->all();

        

        if (isset($request['rooms_count']) && $request['rooms_count'] > 0) {

            $createdRooms = []; 

            for ($i = 0; $i < $request['rooms_count']; $i++) {
                $createdRooms[] = Room::create($inputs);
            }


            return response()->json([
                'success' => true,
                'message' => 'Room created successfully',
                'room' => $createdRooms
            ]);

        } else {

            $room = room::create($inputs);
            return response()->json([
                'success' => true,
                'message' => 'Room created successfully',
                'room' => $room
            ]);
        }

    }

    public function show_api($id)
    {
        $room = room::with('hospital')->find($id);
        if ($room) {
            return response()->json([
                'success' => true,
                'room' => $room
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Room not found'], 404);
        }
    }

    public function update_api(Request $request, $id)
    {
        $room = room::find($id);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Room not found'], 404);
        }

        $inputs = $request->all();




        try {
            $room->update($inputs);
            return response()->json(['success' => true, 'message' => 'Room updated successfully' , 'room' => $room]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }













    public function restore_api($id)
    {
        $room = room::withTrashed()->find($id);
        if ($room) {
            $room->restore();
            return response()->json(['success' => true, 'message' => 'Room restored successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Room not found'], 404);
    }

    public function delete_api($id)
    {
        $room = room::withTrashed()->find($id);
        if ($room) {
            $room->delete();
            return response()->json(['success' => true, 'message' => 'Room deleted permanently.']);
        }
        return response()->json(['success' => false, 'message' => 'Room not found'], 404);
    }


    // Resource Methods-----------------------------------------------------------------------------------------------------------------


    public function index()
    {
        if (Auth::user()->user_type == 2) {
            $rooms = room::where('facility_id', session('facility_id'))->with(['hospital', 'roomClass', 'clinic', 'roomType'])->get();
        } else {

            $rooms = room::all();
        }

        return view('rooms.index')->with('rooms', $rooms);
    }

    public function create()
    {
        // $hospitals = hospital::all();
        $roomsClass = RoomsClass::where('facility_id', session('facility_id'))->get();

        return view('rooms.create')->with(['roomsClass' => $roomsClass]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        room::create($inputs);
        return redirect()->back()->with('flash_message', 'Room added');
    }

    public function show($id)
    {
        $room = room::with('hospital')->findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function showroom($id)
    {
        $room = room::where('facility_id', $id)->get();
        return view('rooms.index', compact('room'));
    }

    public function edit($id)
    {
        $hospitals = hospital::all();
        $roomsClass = RoomsClass::all();
        $clinics = Clinic::all();
        $room_type = room_types::all();
        $rooms = room::with('hospital')->findOrFail($id);

        return view('rooms.edit')->with(['rooms' => $rooms, 'hospitals' => $hospitals, 'roomsClass' => $roomsClass, 'clinics' => $clinics, 'room_type' => $room_type]);
    }

    public function update(Request $request, room $room)
    {
        $inputs = $request->all();
        $updated = $room->update($inputs);

        if ($updated) {
            return redirect()->route('rooms.index')->with('flash_message', 'Room updated successfully!');
        } else {
            return redirect()->back()->with('flash_message', 'Room update failed, no rows affected.');
        }
    }

    public function trash()
    {
        $room_deleted = room::onlyTrashed()->with(['hospital'])->get();
        return view('rooms.trash')->with('room_deleted', $room_deleted);
    }

    public function restore($id)
    {
        $room = room::withTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('rooms.index')->with('success', 'Room restored successfully.');
    }

    public function destroy($id)
    {
        $room = room::find($id);
        if ($room) {
            $room->delete();
        }
        return redirect()->back();
    }
}
