<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

class RoomBooking extends Model
{
    use HasFactory,  EloquentSoftDeletes;
    protected $table = 'rooms_booking';
    protected $primaryKey = 'id';
    protected $fillable = ['room_id', 'patient_id', 'appappointment_id', 'start_date' , 'end_date' , 'payment_status' , 'patients_booked' , 'is_booked' , 'notes' , 'Dialysis_type' , 'way'];
    								
    protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->belongsTo(RoomBooking::class , 'room_id' , 'id');
    }

}
