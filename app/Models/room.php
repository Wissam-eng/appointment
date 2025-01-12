<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

class room extends Model
{
    use HasFactory,  EloquentSoftDeletes;
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    protected $fillable = ['floor_num', 'dep_id', 'room_class', 'facility_id', 'room_type', 'facility_type', 'is_booked'];
    protected $dates = ['deleted_at'];





    public static function boot()
    {
        parent::boot();

        static::deleting(function ($room) {
            if ($room->isForceDeleting()) {
                $room->roomBookings()->forceDelete();
                $room->appointments()->forceDelete();
            } else {
                $room->roomBookings()->delete();
                $room->appointments()->delete();
            }
        });

        static::restoring(function ($room) {
            $room->roomBookings()->withTrashed()->restore();
            $room->appointments()->withTrashed()->restore();
        });
    }














    public function hospital()
    {
        return $this->belongsTo(hospital::class, 'facility_id')->where('facility_type', 1);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'facility_id')->where('facility_type', 2);
    }



    public function roomClass()
    {
        return $this->belongsTo(RoomsClass::class, 'room_class', 'id');
    }

    
    public function roomType()
    {
        return $this->belongsTo(room_types::class, 'room_type', 'id');
    }


    public function appointments()
    {
        return $this->belongsTo(appointments::class, 'id', 'room_id');
    }
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class, 'room_id');
    }
}
