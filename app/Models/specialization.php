<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class specialization extends Model
{

    
    use HasFactory, SoftDeletes;
    protected $table = 'specializations';
    protected $primaryKey = 'id';
    protected $fillable = ['specialization_name', 'specialization_pic' , 'facility_id'];


    public function doctors_specializations()
    {
        return $this->hasMany(Doctors::class);
    }
    public function operation_specializations()
    {
        return $this->hasMany(operations::class);
    }


    public function hospital_specializations()
    {
        return $this->hasMany(hospital::class);
    }
    public function facility()
    {
        return $this->hasMany(facility::class , 'facility_id' , 'id');
    }
    
    public function employees()
    {
        return $this->hasMany(Doctors::class);
    }




    public static function boot()
    {
        parent::boot();

        static::deleting(function ($specializations) {
            if ($specializations->isForceDeleting()) {
                $specializations->doctors_specializations()->forceDelete();
                // $specializations->hospital_specializations()->forceDelete();
                $specializations->employees()->forceDelete();
            } else {
                $specializations->doctors_specializations()->delete();
                // $specializations->hospital_specializations()->delete();
                $specializations->employees()->delete();
            }
        });


        static::restoring(function ($specializations) {
            $specializations->doctors_specializations()->withTrashed()->restore();
            // $specializations->hospital_specializations()->withTrashed()->restore();
            $specializations->employees()->withTrashed()->restore();
        });

    }
}
