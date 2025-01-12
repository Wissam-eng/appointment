<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;



class Hospital extends Model
{
    use HasFactory,  EloquentSoftDeletes;

    protected $table = 'hospital';
    protected $primaryKey = 'id';
    protected $fillable = ['hospital_name', 'hospital_address', 'mobile', 'specialization' , 'profile_pic' , 'room_num'];


    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($hospital) {
            if ($hospital->isForceDeleting()) {
                $hospital->doctors()->forceDelete();
                $hospital->rooms()->forceDelete();
                $hospital->employees()->forceDelete();
            } else {
                $hospital->doctors()->delete();
                $hospital->rooms()->delete();
                $hospital->employees()->delete();
            }
        });

        static::restoring(function ($hospital) {
            $hospital->doctors()->withTrashed()->restore();
            $hospital->rooms()->withTrashed()->restore();
            $hospital->employees()->withTrashed()->restore();
        });
    }


    public function doctors()
    {
        return $this->hasMany(Doctors::class, 'Establishment_id', 'id');
    }
    

    public function employees()
    {
        return $this->hasMany(Doctors::class, 'Establishment_id', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'facility_id', 'id');
    }
    
    public function specializations()
    {
        return $this->belongsTo(specialization::class, 'specialization', 'id');
    }

    
}
