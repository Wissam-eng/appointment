<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointments::all();
        return view('appointments.index')->with('appointments', $appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if (!isset($input['start_date']) || !isset($input['end_date'])) {
            return response()->json(['error' => 'Booking start and end dates are required.'], 400);
        }

        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

        if ($bookingStartDate->greaterThanOrEqualTo($bookingEndDate)) {
            return response()->json(['error' => 'End date must be greater than start date.'], 400);
        }

        if ($request->facility_type == 1 && $request->room_type == 1) {
            $facility = Facility::where('facility_type', $input['facility_type'])
                ->where('id', $input['facility_id'])
                ->first();

            if (!$facility) {
                return response()->json(['error' => 'Facility not found.'], 404);
            }

            $availableRooms = Room::where('facility_id', $facility->id)
                ->where('room_type', $input['room_type'])
                ->where('room_class', $input['room_class'])
                ->get();

            $availableRoom = null;
            foreach ($availableRooms as $room) {
                $currentPatientsCount = RoomBooking::where('room_id', $room->id)
                    ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                        $query->whereBetween('start_date', [$bookingStartDate, $bookingEndDate])
                            ->orWhereBetween('end_date', [$bookingStartDate, $bookingEndDate])
                            ->orWhere(function ($q) use ($bookingStartDate, $bookingEndDate) {
                                $q->where('start_date', '<=', $bookingStartDate)
                                    ->where('end_date', '>=', $bookingEndDate);
                            });
                    })
                    ->count();

                if ($currentPatientsCount < $room->roomClass->number_beds) {
                    $availableRoom = $room;
                    break;
                }
            }

            if (!$availableRoom) {
                return response()->json(['error' => 'Sorry, no room available for the selected date range.'], 404);
            }

            $roomBooking = new RoomBooking();
            $roomBooking->room_id = $availableRoom->id;
            $roomBooking->start_date = $bookingStartDate;
            $roomBooking->end_date = $bookingEndDate;
            $roomBooking->patient_id = $input['user_id'];

            $currentPatientsCount += 1;

            if ($currentPatientsCount >= $availableRoom->roomClass->number_beds) {
                $roomBooking->is_booked = 1;
                $availableRoom->is_booked = 1;
            } else {
                $roomBooking->is_booked = 0;
            }

            $roomBooking->save();
            $availableRoom->patients_booke = $currentPatientsCount;
            $availableRoom->save();

            $input['room_id'] = $availableRoom->id;
            $input['booking_data'] = $roomBooking->id;
        }


        $appointments = Appointments::create($input);

        return redirect()->route('appointments.index')->with(['flash_message' => 'Room booked successfully.', 'appointments' => $appointments]);
    }






    public function store_api(Request $request)
    {
        try {
            $input = $request->all();

            if (!isset($input['start_date']) || !isset($input['end_date'])) {
                return response()->json(['error' => 'Booking start and end dates are required.'], 400);
            }

            $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
            $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

            if ($bookingStartDate->greaterThanOrEqualTo($bookingEndDate)) {
                return response()->json(['error' => 'End date must be greater than start date.'], 400);
            }

            if ($request->facility_type == 1 && $request->room_type == 1) {
                $facility = Facility::where('facility_type', $input['facility_type'])
                    ->where('id', $input['facility_id'])
                    ->first();

                if (!$facility) {
                    return response()->json(['error' => 'Facility not found.'], 404);
                }

                $availableRooms = Room::where('facility_id', $facility->id)
                    ->where('room_type', $input['room_type'])
                    ->where('room_class', $input['room_class'])
                    ->get();

                $availableRoom = null;
                foreach ($availableRooms as $room) {
                    $currentPatientsCount = RoomBooking::where('room_id', $room->id)
                        ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                            $query->whereBetween('start_date', [$bookingStartDate, $bookingEndDate])
                                ->orWhereBetween('end_date', [$bookingStartDate, $bookingEndDate])
                                ->orWhere(function ($q) use ($bookingStartDate, $bookingEndDate) {
                                    $q->where('start_date', '<=', $bookingStartDate)
                                        ->where('end_date', '>=', $bookingEndDate);
                                });
                        })
                        ->count();

                    if ($currentPatientsCount < $room->roomClass->number_beds) {
                        $availableRoom = $room;
                        break;
                    }
                }

                if (!$availableRoom) {
                    return response()->json(['error' => 'Sorry, no room available for the selected date range.'], 404);
                }

                $roomBooking = new RoomBooking();
                $roomBooking->room_id = $availableRoom->id;
                $roomBooking->start_date = $bookingStartDate;
                $roomBooking->end_date = $bookingEndDate;
                $roomBooking->patient_id = $input['user_id'];

                $currentPatientsCount += 1;

                if ($currentPatientsCount >= $availableRoom->roomClass->number_beds) {
                    $roomBooking->is_booked = 1;
                    $availableRoom->is_booked = 1;
                } else {
                    $roomBooking->is_booked = 0;
                }

                $roomBooking->save();
                $availableRoom->patients_booke = $currentPatientsCount;
                $availableRoom->save();

                $input['room_id'] = $availableRoom->id;
                $input['booking_data'] = $roomBooking->id;
            }


            $appointments = Appointments::create($input);

            return response()->json($appointments, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }













    public function update_api(Request $request, $id)
    {
        try {
            $appointment = Appointments::findOrFail($id);
            $input = $request->all();

            if (!isset($input['start_date']) || !isset($input['end_date'])) {
                return response()->json(['error' => 'Booking start and end dates are required.'], 400);
            }

            $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
            $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

            if ($bookingStartDate->greaterThanOrEqualTo($bookingEndDate)) {
                return response()->json(['error' => 'End date must be greater than start date.'], 400);
            }

            if ($request->facility_type == 1 && $request->room_type == 1) {
                $facility = Facility::where('facility_type', $input['facility_type'])
                    ->where('id', $input['facility_id'])
                    ->first();

                if (!$facility) {
                    return response()->json(['error' => 'Facility not found.'], 404);
                }

                $availableRooms = Room::where('facility_id', $facility->id)
                    ->where('room_type', $input['room_type'])
                    ->where('room_class', $input['room_class'])
                    ->get();

                $availableRoom = null;
                foreach ($availableRooms as $room) {
                    $currentPatientsCount = RoomBooking::where('room_id', $room->id)
                        ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                            $query->whereBetween('start_date', [$bookingStartDate, $bookingEndDate])
                                ->orWhereBetween('end_date', [$bookingStartDate, $bookingEndDate])
                                ->orWhere(function ($q) use ($bookingStartDate, $bookingEndDate) {
                                    $q->where('start_date', '<=', $bookingStartDate)
                                        ->where('end_date', '>=', $bookingEndDate);
                                });
                        })
                        ->count();

                    if ($currentPatientsCount < $room->roomClass->number_beds) {
                        $availableRoom = $room;
                        break;
                    }
                }

                if (!$availableRoom) {
                    return response()->json(['error' => 'Sorry, no room available for the selected date range.'], 404);
                }

                $roomBooking = new RoomBooking();
                $roomBooking->room_id = $availableRoom->id;
                $roomBooking->start_date = $bookingStartDate;
                $roomBooking->end_date = $bookingEndDate;
                $roomBooking->patient_id = $input['user_id'];

                $currentPatientsCount += 1;

                if ($currentPatientsCount >= $availableRoom->roomClass->number_beds) {
                    $roomBooking->is_booked = 1;
                    $availableRoom->is_booked = 1;
                } else {
                    $roomBooking->is_booked = 0;
                }

                $roomBooking->save();
                $availableRoom->patients_booke = $currentPatientsCount;
                $availableRoom->save();

                $input['room_id'] = $availableRoom->id;
                $input['booking_data'] = $roomBooking->id;
            }

            if ($appointment->booking_data) {
                $appointment->booking_data->delete();
            }

            $appointment->update($input);

            return response()->json($appointment, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }







    public function show(Appointments $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }






    public function edit(Appointments $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }




    public function update(Request $request, Appointments $appointment)
    {
        $input = $request->all();
        $appointment->update($input);

        return redirect()->route('appointments.index')->with('flash_message', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointments $appointment)
    {
        $booked_Room = Room::where('id', $appointment->room_id);
        $booked_Room->patients_booke - 1;
        $booked_Room->is_booked = 0;
        $booked_Room->save();
        $appointment->delete();
        return redirect()->route('appointments.index')->with('flash_message', 'Appointment deleted successfully.');
    }

    public function destroy_api($id)
    {
        try {
            $appointment = Appointments::findOrFail($id);
            $booked_Room = Room::where('id', $appointment->room_id)->first();

            if ($booked_Room) {
                $booked_Room->patients_booke -= 1;

                if ($booked_Room->is_booked > 0) {
                    $booked_Room->is_booked = 0;
                }

                $booked_Room->save();
            }

            $appointment->delete();
            return response()->json(['message' => 'Appointment deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    public function delete_api($id)
    {
        try {
            $appointment = Appointments::findOrFail($id);
            $booked_Room = Room::where('id', $appointment->room_id)->first();

            if ($booked_Room) {
                $booked_Room->patients_booke -= 1;

                if ($booked_Room->is_booked > 0) {
                    $booked_Room->is_booked = 0;
                }

                $booked_Room->save();
            }

            $appointment->forceDelete();
            return response()->json(['message' => 'Appointment deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function restore_api($id)
    {
        try {
            $appointment = Appointments::withTrashed()->findOrFail($id);
            $appointment->restore();

            $booked_Room = Room::with('roomClass')->where('id', $appointment->room_id)->first();

            if ($booked_Room) {
                if ($booked_Room->is_booked == 0 && ($booked_Room->roomClass->number_beds > $booked_Room->patients_booke)) {
                    $booked_Room->patients_booke += 1;

                    if ($booked_Room->roomClass->number_beds == $booked_Room->patients_booke) {
                        $booked_Room->is_booked = 1;
                    } else {
                        $booked_Room->is_booked = 0;
                    }
                } else {
                    return response()->json(['message' => 'Sorry, the room is booked.'], 203);
                }

                $booked_Room->save();
            }

            return response()->json(['message' => 'Appointment restored successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}