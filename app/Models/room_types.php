<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_types extends Model
{
    use HasFactory;


    protected $table = 'room_types';
    protected $primaryKey = 'id';
    protected $fillable = ['room_type_name' , 'profile_pic' , 'facility_id' ];

    public function Facility()
    {
        return $this->belongsTo(Facility::class);
    }


    public function room()
    {
        return $this->hasMany(room::class , 'room_type' , 'id');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($room_types) {
    
                $room_types->room()->delete();
   
            
        });


    }

}
