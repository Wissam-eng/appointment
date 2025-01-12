<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class appointments extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;


    protected $table = 'appointments';

    protected $primaryKey = 'id';

    protected $fillable = ['room_id', 'room_type', 'facility_type', 'facility_id', 'user_id', 'old_child', 'room_class', 'operation', 'doctor', 'Specialization', 'start_date', 'end_date', 'note', 'booking_data', 'Dialysis_type', 'booking_type', 'analysis_id' , 'way'];


    public function facilities()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
    
    
    
    public function booking_data()
    {
        return $this->belongsTo(RoomBooking::class, 'booking_data', 'id');
    }







    public function room()
    {
        return $this->belongsTo(room::class, 'room_id' , 'id'); // 'doctor' is the foreign key in appointments
    }


    public function analyses()
    {
        return $this->belongsTo(analysis::class, 'analysis_id' , 'id'); // 'doctor' is the foreign key in appointments
    }


    public function operation()
    {
        return $this->belongsTo(operations::class, 'operation' , 'id'); 
    }


    public function doctor()
    {
        return $this->belongsTo(Doctors::class, 'doctor' , 'id'); // 'doctor' is the foreign key in appointments
    }


    public function user()
    {
        return $this->belongsTo(profile::class , 'user_id' , 'user_id');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($appointments) {
            if ($appointments->isForceDeleting()) {
                $appointments->booking_data()->forceDelete();
            } else {
                $appointments->booking_data()->delete();
            }
        });

        static::restoring(function ($appointments) {
            $appointments->booking_data()->withTrashed()->restore();
        });
    }
}
