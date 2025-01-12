<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\appointments;
use App\Models\Doctors;
use App\Models\Facility;
use App\Models\room;
use App\Models\profile;

use App\Models\analysis;
use App\Models\User;
use App\Models\Subscribed;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomBooking;
use App\Models\ClientAdvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class AppointmentsController extends Controller
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
        $user_id = session('user_id');
        if (session('user_type') == 2) {

            $appointments = appointments::where('facility_id', session('facility_id'))->with('booking_data', 'user')->get();
        } elseif (session('user_type') == 3) {

            $appointments = appointments::where('user_id', $user_id)->get();
        }



        return view('appointments.index')->with('appointments', $appointments);
    }



    public function trash()
    {
        $facility_id = session('facility_id');
        $appointments = appointments::withTrashed()->where('facility_id', $facility_id)->get();
        return view('appointments.trash')->with('appointments', $appointments);
    }





    public function index_api(Request $request)
    {



        $appointments = appointments::with('facilities')->where('user_id', $request->user_id)->get();
        $ads = ClientAdvertisement::all();

        return response()->json([
            'success' => true,
            'appointments_later' => $appointments,

            'ads' => $ads,
            'offers' => $ads
        ]);
    }


    public function my_appointments(Request $request)
    {

        $later_appointments = appointments::select('id' , 'facility_id', 'booking_type', 'booking_data', 'analysis_id', 'created_at', 'start_date', 'end_date', 'room_id', 'old_child', 'operation', 'user_id', 'doctor')->with([

            'facilities' => function ($query) {
                $query->select('id' , 'name'); // Include 'id' column
            },

            'booking_data' => function ($query) {
                $query->select('id', 'Dialysis_type', 'way'); // Include 'id' column
            },
            'analyses' => function ($query) {
                $query->select('id', 'analysis_name', 'analysis_pic'); // Include 'id' column

            },
            'operation' => function ($query) {
                $query->select('id', 'operation_name', 'specialization_id', 'operation_pic'); // Include 'id' column

            },
            'operation.specialization' => function ($query) {
                $query->select('id', 'specialization_name'); // Include 'id' column

            },

            'room' => function ($query) {
                $query->select('id', 'room_type', 'room_class'); // Include 'id' column

            },
            'room.roomType' => function ($query) {
                $query->select('id', 'room_type_name'); // Include 'id' column

            },
            'room.roomClass' => function ($query) {
                $query->select('id', 'roomsClass_name'); // Include 'id' column

            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'specialization_id', 'gender', 'profile_pic'); // Include 'id' column

            },
            'doctor.specialization' => function ($query) {
                $query->select('id', 'specialization_name'); // Select specialization details
            }
        ])->where('user_id', $request->user_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [Carbon::parse($request->from)->startOfDay(), Carbon::parse($request->to)->endOfDay()])
                    ->orWhereBetween('end_date', [Carbon::parse($request->from)->startOfDay(), Carbon::parse($request->to)->endOfDay()]);
            })
            ->get();


        return response()->json([
            'success' => true,
            'later_appointments' => $later_appointments
        ]);
    }


    public function appointments_facility(Request $request)
    {
        
      

        $appointments = appointments::select('id', 'user_id', 'booking_type', 'analysis_id', 'created_at', 'start_date', 'end_date', 'room_id', 'old_child', 'operation', 'doctor')->with([
            'user' => function ($query) {
                $query->select('user_id' , 'first_name', 'last_name', 'mobile'); 
            },


            'analyses' => function ($query) {
                $query->select('id', 'analysis_name', 'analysis_pic'); // Include 'id' column

            },
            'operation' => function ($query) {
                $query->select('id', 'operation_name', 'specialization_id', 'operation_pic'); // Include 'id' column

            },
            'operation.specialization' => function ($query) {
                $query->select('id', 'specialization_name'); // Include 'id' column

            },

            'room' => function ($query) {
                $query->select('id', 'room_type', 'room_class'); // Include 'id' column

            },
            'room.roomType' => function ($query) {
                $query->select('id', 'room_type_name'); // Include 'id' column

            },
            'room.roomClass' => function ($query) {
                $query->select('id', 'roomsClass_name'); // Include 'id' column

            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'specialization_id', 'gender', 'profile_pic'); // Include 'id' column

            },
            'doctor.specialization' => function ($query) {
                $query->select('id', 'specialization_name'); // Select specialization details
            }
        ])->where('facility_id', $request->facility_id)->get();



        return response()->json([
            'success' => true,
            'appointments_later' => $appointments
        ]);
    }

    public function history(Request $request)
    {
        $booking_type = $request->booking_type;
        $user_id = $request->user_id;

        $booking_types_names = [
            1 => 'residency_history',
            2 => 'operations_history',
            3 => 'nursery_history',
            4 => 'intensive_care_history',
            5 => 'dialysis_history',
            6 => 'consultation_history',
            7 => 'medical_tests_history'
        ];

        if (!isset($booking_types_names[$booking_type])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid booking type'
            ], 400);
        }

        $history_key = $booking_types_names[$booking_type];



        $appointments = appointments::select('id', 'booking_type', 'booking_data', 'analysis_id', 'created_at', 'start_date', 'end_date', 'room_id', 'old_child', 'operation', 'user_id', 'doctor')->with([

            'booking_data' => function ($query) {
                $query->select('id', 'Dialysis_type', 'way'); // Include 'id' column
            },
            'analyses' => function ($query) {
                $query->select('id', 'analysis_name', 'analysis_pic'); // Include 'id' column

            },
            'operation' => function ($query) {
                $query->select('id', 'operation_name', 'specialization_id', 'operation_pic'); // Include 'id' column

            },
            'operation.specialization' => function ($query) {
                $query->select('id', 'specialization_name'); // Include 'id' column

            },

            'room' => function ($query) {
                $query->select('id', 'room_type', 'room_class'); // Include 'id' column

            },
            'room.roomType' => function ($query) {
                $query->select('id', 'room_type_name'); // Include 'id' column

            },
            'room.roomClass' => function ($query) {
                $query->select('id', 'roomsClass_name'); // Include 'id' column

            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'specialization_id', 'gender', 'profile_pic'); // Include 'id' column

            },
            'doctor.specialization' => function ($query) {
                $query->select('id', 'specialization_name'); // Select specialization details
            }
        ])->where('booking_type', $booking_type)->where('user_id', $user_id)->get();




        return response()->json([
            'success' => true,
            $history_key => $appointments
        ]);
    }


    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if (!$this->validateBookingDates($input)) {
            return response()->json(['error' => 'Booking start and end dates are required or invalid.'], 400);
        }

        $facility = Facility::where('id', $input['facility_id'])->first();

        if (!$facility) {
            return response()->json(['error' => 'Facility not found.'], 404);
        }

        $availableRoom = $this->getAvailableRoom($facility, $input);

        if (!$availableRoom) {
            return response()->json(['error' => 'No room available for the selected date range.'], 404);
        }

        $roomBooking = $this->bookRoom($availableRoom, $input);

        $input['room_id'] = $availableRoom->id;
        $input['booking_data'] = $roomBooking->id;
        $appointments = appointments::create($input);

        return redirect()->route('appointments.index')
            ->with(['flash_message' => 'room booked successfully.', 'appointments' => $appointments]);
    }




    public function destroy_api($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired or is invalid.',
            ], 401);
        }


        try {

            $appointment = appointments::findOrFail($id);

            // return response()->json(['appointment' => $appointment], 200);

            if ($appointment->booking_type == 1 || $appointment->booking_type == 2) {
                $booked_Room = room::find($appointment->room_id);
                if ($booked_Room) {
                    $booked_Room->patients_booked -= 1;
                    $booked_Room->is_booked = $booked_Room->patients_booked >= $booked_Room->roomClass->number_beds ? 1 : 0;
                    $booked_Room->save();
                }

                $appointment->delete();
                return response()->json(['message' => 'Appointment deleted successfully.'], 200);
            } elseif ($appointment->booking_type == 5 || $appointment->booking_type == 3) {
                $user_id = $appointment->user_id;
                $existingAppointments = appointments::where('user_id', $user_id)->where('booking_type', 5)->orWhere('booking_type', 3)->get();

                foreach ($existingAppointments as $appointmentRecord) {
                    $bookingData = RoomBooking::where('id', $appointmentRecord->booking_data)
                        ->where('patient_id', $user_id)
                        ->first();

                    if ($bookingData) {
                        $bookingData->forceDelete();
                    }

                    $appointmentRecord->forceDelete();
                }

                return response()->json(['message' => 'appointments successfully deleted.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        try {
            $appointment = appointments::findOrFail($id);

            if (in_array($appointment->booking_type, [1, 2])) {
                $bookedRoom = room::find($appointment->room_id);

                if ($bookedRoom) {
                    // Perform additional actions on the room if necessary
                }

                $appointment->delete();
                return redirect()->back()->with('success', 'Appointment deleted successfully.');
            } elseif (in_array($appointment->booking_type, [5, 3])) {
                $user_id = $appointment->user_id;

                $existingAppointments = appointments::where('user_id', $user_id)
                    ->where(function ($query) {
                        $query->where('booking_type', 5)
                            ->orWhere('booking_type', 3);
                    })
                    ->get();

                foreach ($existingAppointments as $appointmentRecord) {
                    $bookingData = RoomBooking::where('id', $appointmentRecord->booking_data)
                        ->where('patient_id', $user_id)
                        ->first();

                    if ($bookingData) {
                        $bookingData->forceDelete();
                    }

                    $appointmentRecord->forceDelete();
                }

                return redirect()->back()->with('success', 'Appointment and associated data deleted successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function delete_api($id)
    {
        try {
            $appointment = appointments::findOrFail($id);
            $booked_Room = room::find($appointment->room_id);

            if ($booked_Room) {
                $booked_Room->patients_booked -= 1;
                $booked_Room->is_booked = $booked_Room->patients_booked > 0 ? 1 : 0;
                $booked_Room->save();
            }

            $appointment->forceDelete();
            return response()->json(['message' => 'Appointment deleted permanently.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function restore_api($id)
    {
        try {
           
            $appointment = appointments::withTrashed()->find($id);
            
            if(!$appointment){
                return response()->json(['success' => false , 'message' => 'appointment is not found '], 420);
            }
            
            $appointment->restore();

            $booked_Room = room::find($appointment->room_id);
            if ($booked_Room && $booked_Room->patients_booked < $booked_Room->roomClass->number_beds) {
                $booked_Room->patients_booked += 1;
                $booked_Room->is_booked = $booked_Room->patients_booked >= $booked_Room->roomClass->number_beds ? 1 : 0;
                $booked_Room->save();
            } else {
                return response()->json(['message' => 'Sorry, the room is already fully booked.'], 403);
            }

            return response()->json(['message' => 'Appointment restored successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    private function validateBookingDates($input)
    {
        if (!isset($input['start_date']) || !isset($input['end_date'])) {
            return false;
        }

        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);
        return $bookingStartDate->lessThan($bookingEndDate);
    }




    public function store_api(Request $request)
    {
        try {


            $input = $request->all();

            if (!isset($input['start_date']) || !isset($input['end_date'])) {
                return response()->json(['error' => 'Start and end dates are required.'], 400);
            }

            $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
            $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

            if (!$this->validateBookingDates($input)) {
                return response()->json(['error' => 'Invalid booking dates.'], 400);
            }

            $facility = Facility::find($input['facility_id']);
            if (!$facility) {
                return response()->json(['error' => 'Facility not found.'], 404);
            }

            if ($input['booking_type'] == 1 || $input['booking_type'] == 2 || $input['booking_type'] == 3 || $input['booking_type'] == 4) {
                $availableRoom = $this->getAvailableRoom($facility, $input);
                if (!$availableRoom) {
                    return response()->json(['error' => 'No room available for the selected date range.'], 404);
                }

                $roomBooking = $this->bookRoom($availableRoom, $input);
                $input['room_id'] = $availableRoom->id;
                $input['booking_data'] = $roomBooking->id;
                $appointments = appointments::create($input);
                return response()->json($appointments, 201);
            } elseif ($input['booking_type'] == 5) {
                return $this->bookDialysis($input, $facility);
            } elseif ($input['booking_type'] == 6) {
                return $this->bookDoctorAppointment($input, $facility);
            } elseif ($input['booking_type'] == 7) {

                return $this->bookanalysis($input, $facility);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    private function bookDoctorAppointment($input, $facility)
    {
        $doctor = $input['doctor'];
        $data_dr = Doctors::where('id', $doctor)->where('Establishment_id', $facility->id)->first();



        if (!$data_dr) {
            return response()->json(['error' => 'Doctor not found: ' . $doctor], 400);
        }

        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingStartTime = $bookingStartDate->format('H:i:s');
        $bookingEndTime = \Carbon\Carbon::parse($input['end_date'])->format('H:i:s');

        $workDays = json_decode($data_dr->work_days, true);
        $bookingDay = $bookingStartDate->format('N');

        if (!in_array($bookingDay, $workDays)) {
            return response()->json(['error' => 'Booking day is not a working day.'], 400);
        }

        if ($bookingStartTime < $data_dr->duty_start || $bookingEndTime > $data_dr->duty_end) {
            return response()->json(['error' => 'Booking time is outside of working hours. the start time is ' . $data_dr->duty_start . ' and the end time is ' . $data_dr->duty_end], 400);
        }

        $appointmentExists = appointments::where('doctor', $doctor)
            ->whereDate('start_date', $bookingStartDate->format('Y-m-d'))
            ->where(function ($query) use ($bookingStartDate) {
                $query->where('start_date', '<=', $bookingStartDate)
                    ->where('end_date', '>=', $bookingStartDate);
            })->exists();

        if ($appointmentExists) {
            return response()->json(['error' => 'There are no appointments available.'], 404);
        }

        $appointments = appointments::create($input);
        return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointments], 201);
    }

    private function bookDialysis($input, $facility)
    {
        $availableRoom = $this->getAvailableRoom($facility, $input);
        if (!$availableRoom) {
            return response()->json(['error' => 'No room available for the selected date range.'], 404);
        }

        $appointmentsList = [];

        if ($input['Dialysis_type'] == 1) {
            // Weekly recurring dialysis (Type 1)
            $startDate = new \DateTime($input['start_date']);
            $end_date = new \DateTime($input['end_date']);
            $repeatCount = ($input['way'] == 1) ? 2 : 3;  // Two or three appointments per week

            for ($i = 0; $i < 52; $i++) {  // Book for 52 weeks
                for ($j = 0; $j < $repeatCount; $j++) {
                    $appointmentDate = clone $startDate;
                    $appointmentDate_end_date = clone $end_date;
                    $daysToAdd = intval(7 / $repeatCount) * $j;  // Spacing appointments within the week
                    $appointmentDate->modify("+{$daysToAdd} days");
                    $input['start_date'] = $appointmentDate->format('Y-m-d H:i:s');
                    $input['end_date'] = $appointmentDate_end_date->format('Y-m-d H:i:s');

                    $availableRoom = $this->getAvailableRoom($facility, $input);
                    if (!$availableRoom) {
                        return response()->json(['error' => 'No room available for the selected date range.'], 404);
                    }

                    $roomBooking = $this->bookRoom($availableRoom, $input);
                    $input['room_id'] = $availableRoom->id;
                    $input['booking_data'] = $roomBooking->id;
                    
                    
                    $newInput = array_diff_key($input, array_flip(['way']));

                    $appointment = appointments::create($newInput);
                    $appointmentsList[] = $appointment;
                }

                $startDate->modify('+1 week');  // Move to the next week
            }

            return response()->json(['message' => 'appointments successfully booked.', 'appointments' => $appointmentsList]);
        } elseif ($input['Dialysis_type'] == 2) {
            // One-time dialysis booking (Type 2)
            $roomBooking = $this->bookRoom($availableRoom, $input);
            $input['room_id'] = $availableRoom->id;
            $input['booking_data'] = $roomBooking->id;
            
            

              $newInput = array_diff_key($input, array_flip(['way']));

            $appointment = appointments::create($newInput);

            return response()->json(['message' => 'Appointment successfully booked.', 'appointments' => $appointment]);
        }
    }



    private function bookanalysis($input, $facility)
    {
        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);



        $conflict = appointments::where('booking_type', $input['booking_type'])->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
            $query->where('start_date', '<', $bookingEndDate)
                ->where('end_date', '>', $bookingStartDate);
        })->exists();

        if ($conflict) {
            return response()->json(['error' => 'There is already an appointment at this time'], 422);
        }

        $numbr_analyisi_allow = analysis::where(['facility_id' => $input['facility_id'],  'id' => $input['analysis_id']])->first();


        if (!$numbr_analyisi_allow) {
            return response()->json([
                'error' => 'There is no analysis in facility'
            ], 422);
        }



        $total_analyses = appointments::where('booking_type', $input['booking_type'])
            ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                $query->whereDate('start_date', '>=', $bookingStartDate->format('Y-m-d 00:00:00'))
                    ->whereDate('end_date', '<=', $bookingEndDate->format('Y-m-d 23:59:59'));
            })->count();



        $max_analyses =  $numbr_analyisi_allow->max_analyses;

        if ($total_analyses >= $max_analyses) {
            return response()->json([
                'error' => 'The maximum number of analyses for this day has been reached',
                'total_analyses' => $total_analyses
            ], 422);
        }

        $Appointment =  appointments::create($input);

        return response()->json([
            'success' => 'Appointment booked successfully',
            'Appointment' => $Appointment
        ], 200);
    }
    
    
    private function update_analysis($input, $facility , $id)
    {
        
            
        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);
        
          
        
        $appointment = appointments::find($id);
        
     
        
        if(!$appointment){
            
               return response()->json([
                'error' => 'There is no appointment'
            ], 422);
            
        }


        $conflict = appointments::where('booking_type', $input['booking_type'])->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
            $query->where('start_date', '<', $bookingEndDate)
                ->where('end_date', '>', $bookingStartDate);
        })->exists();


        if ($conflict) {
            return response()->json(['error' => 'There is already an appointment at this time'], 422);
        }

        $numbr_analyisi_allow = analysis::where(['facility_id' => $input['facility_id'],  'id' => $input['analysis_id']])->first();


        if (!$numbr_analyisi_allow) {
            return response()->json([
                'error' => 'There is no analysis in facility'
            ], 422);
        }



        $total_analyses = appointments::where('booking_type', $input['booking_type'])
            ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                $query->whereDate('start_date', '>=', $bookingStartDate->format('Y-m-d 00:00:00'))
                    ->whereDate('end_date', '<=', $bookingEndDate->format('Y-m-d 23:59:59'));
            })->count();



        $max_analyses =  $numbr_analyisi_allow->max_analyses;

        if ($total_analyses >= $max_analyses) {
            return response()->json([
                'error' => 'The maximum number of analyses for this day has been reached',
                'total_analyses' => $total_analyses
            ], 422);
        }
        
        
        
        $Appointment_updated = $appointment->update($input);

       
        return response()->json([
            'success' => 'Appointment booked successfully',
            'Appointment' => $Appointment_updated
        ], 200);
    }




    private function getAvailableRoom($facility, $input)
    {
        if (!isset($input['start_date']) || !isset($input['end_date'])) {
            return false;
        }

        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

        $availableRooms = room::where('facility_id', $facility->id)
            ->where('room_type', $input['room_type'])
            ->where('room_class', $input['room_class'])
            ->get();

        foreach ($availableRooms as $room) {
            $currentBooking = RoomBooking::where('room_id', $room->id)
                ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                    $query->where('start_date', '<', $bookingEndDate)
                        ->where('end_date', '>', $bookingStartDate)
                        ->where('is_booked', 1);
                })->exists();

            if (!$currentBooking) {
                return $room;
            }
        }

        return null;
    }

    private function bookRoom($availableRoom, $input)
    {
        
        
        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

        $overlappingBookings = RoomBooking::where('room_id', $availableRoom->id)
            ->where(function ($query) use ($bookingStartDate, $bookingEndDate) {
                $query->where('start_date', '<=', $bookingEndDate)
                    ->where('end_date', '>=', $bookingStartDate);
            })->get();



        $totalPatientsBooked = $overlappingBookings->sum('patients_booked');
        $newPatientsBooked = $totalPatientsBooked + 1;

              
        if ($newPatientsBooked <= $availableRoom->roomClass->number_beds) {
            $isFullyBooked = $newPatientsBooked >= $availableRoom->roomClass->number_beds;
        
            $roomBooking = RoomBooking::create([
                'room_id' => $availableRoom->id,
                'doctor' => $input['doctor'] ?? null,
                'old_child' => $input['old_child'] ?? null,
                'patient_id' => $input['user_id'],
                'way' => $input['way'] ?? null,
                'Dialysis_type' => $input['Dialysis_type'] ?? null,
                'start_date' => $input['start_date'],
                'end_date' => $input['end_date'],
                'patients_booked' => $newPatientsBooked,
                'notes' => $input['note'] ?? null,
                'is_booked' => $isFullyBooked ? 1 : 0,
            ]);
        
            $availableRoom->is_booked = $isFullyBooked;
            $availableRoom->save();
        
            return $roomBooking;
        } else {
            return null;
        }

    }




    public function update_api(Request $request, $appointmentId)
    {
          
        try {
            
            $input = $request->all();

            if (!isset($input['start_date']) || !isset($input['end_date'])) {
                return response()->json(['error' => 'Start and end dates are required.'], 400);
            }

            $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
            $bookingEndDate = \Carbon\Carbon::parse($input['end_date']);

            if (!$this->validateBookingDates($input)) {
                return response()->json(['error' => 'Invalid booking dates.'], 400);
            }

            $facility = Facility::find($input['facility_id']);
            if (!$facility) {
                return response()->json(['error' => 'Facility not found.'], 404);
            }

            $appointment = appointments::find($appointmentId);
            if (!$appointment) {
                return response()->json(['error' => 'Appointment not found.'], 404);
            }
            
   
            

                if ($input['booking_type'] == 1 || $input['booking_type'] == 2 || $input['booking_type'] == 3 || $input['booking_type'] == 4) {
                $availableRoom = $this->getAvailableRoom($facility, $input);
                if (!$availableRoom) {
                    return response()->json(['error' => 'No room available for the selected date range.'], 404);
                }

                $roomBooking = $this->bookRoom($availableRoom, $input);
                $input['room_id'] = $availableRoom->id;
                $input['booking_data'] = $roomBooking->id;

                $appointment->update($input);
                return response()->json($appointment, 200);
                
                } elseif ($input['booking_type'] == 5) {
                    
                   
                    
                return $this->updateDialysis($input, $facility, $appointmentId);
                
                } elseif ($input['booking_type'] == 6) {
                return $this->updateDoctorAppointment($input, $facility, $appointment);
                }elseif ($input['booking_type'] == 7) {
    
                    return $this->update_analysis($input, $facility  , $appointmentId);
                }
                
                
                
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    private function updateDoctorAppointment($input, $facility, $appointment)
    {
        $doctor = $input['doctor'];
        $data_dr = Doctors::where('id', $doctor)
            ->where('Establishment_id', $facility->id)
            ->first();

        if (!$data_dr) {
            return response()->json(['error' => 'Doctor not found: ' . $doctor], 400);
        }

        $bookingStartDate = \Carbon\Carbon::parse($input['start_date']);
        $bookingStartTime = $bookingStartDate->format('H:i:s');
        $bookingEndTime = \Carbon\Carbon::parse($input['end_date'])->format('H:i:s');

        $workDays = json_decode($data_dr->work_days, true);
        $bookingDay = $bookingStartDate->format('N');

        if (!in_array($bookingDay, $workDays)) {
            return response()->json(['error' => 'Booking day is not a working day.'], 400);
        }

        if ($bookingStartTime < $data_dr->duty_start || $bookingEndTime > $data_dr->duty_end) {
            return response()->json(['error' => 'Booking time is outside of working hours.'], 400);
        }

        $appointmentExists = appointments::where('doctor', $doctor)
            ->whereDate('start_date', $bookingStartDate->format('Y-m-d'))
            ->where(function ($query) use ($bookingStartDate) {
                $query->where('start_date', '<=', $bookingStartDate)
                    ->where('end_date', '>=', $bookingStartDate);
            })
            ->where('id', '!=', $appointment->id) // استبعاد الموعد الحالي
            ->exists();

        if ($appointmentExists) {
            return response()->json(['error' => 'There are no appointments available.'], 404);
        }

        $appointment->update($input);
        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment], 200);
    }


    private function updateDialysis($input, $facility, $appointment)
    {
        
      
        $user_id = $input['user_id'];

        // Retrieve existing appointments for the user
        $existingAppointments = appointments::where('user_id', $user_id)->where('booking_type', 5)->get();
       
        if($existingAppointments->isEmpty()){
             return response()->json(['success' => false , 'message' => 'appointments not link wiht   user.']);
        }

        $appointmentsList = [];
        $startDate = new \DateTime($input['start_date']);
        $repeatCount = ($input['way'] == 1) ? 2 : 3;

        // Loop to delete existing appointments and create new ones
        foreach ($existingAppointments as $appointmentRecord) {
            $bookingData = RoomBooking::where('id', $appointmentRecord->booking_data)
                ->where('patient_id', $user_id)
                ->first();

            if ($bookingData) {
                // Update room booking's start_date and save
                $bookingData->start_date = $startDate->format('Y-m-d H:i:s');
                $bookingData->save();
            }

            // Update appointment's start_date and save
            $appointmentRecord->start_date = $startDate->format('Y-m-d H:i:s');
            $appointmentRecord->save();

            // Add updated appointment information to the appointments list
            $appointmentsList[] = [
                'id' => $appointmentRecord->id,
                'start_date' => $appointmentRecord->start_date,
                'booking_data' => $bookingData ? $bookingData->id : null, // Include booking data ID if available
            ];
        }

        // Optional: Create new appointments logic can go here
        // ...

        return response()->json(['message' => 'appointments successfully updated.', 'appointments' => $appointmentsList]);
    }
}
