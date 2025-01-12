<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class RoomsClass extends Model
{
    use HasFactory , HasApiTokens , Notifiable , EloquentSoftDeletes;

    protected $table = 'rooms_classes';

    protected $primaryKey = 'id';

    protected $fillable = ['roomsClass_name' , 	'price_day' ,	'number_companions' , 	'number_beds' , 'wifi' , 'room_type' , 'facility_id'];

    protected $dates = ['deleted_at'];


    // public function hospital_rooms_classes()
    // {
    //     return $this->hasMany(hospital::class);
    // }


    public function rooms()
    {
        return $this->hasMany(Room::class , 'room_class' , 'id');
    }



    public static function boot()
    {
        parent::boot();
 
        static::deleting(function ($rooms_classes) {
            if ($rooms_classes->isForceDeleting()) {
                $rooms_classes->rooms()->forceDelete();
            } else {
                $rooms_classes->rooms()->delete();
            }
        });
 
        static::restoring(function ($rooms_classes) {
            $rooms_classes->rooms()->withTrashed()->restore();
        });
    }
}
