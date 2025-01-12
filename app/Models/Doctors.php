<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Doctors extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;


    protected $table = 'doctors';

    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'second_name',
        'third_name',
        'last_name',
        'date_birth',
        'mobile',
        'old',
        'gender',
        'martial_status',
        'department_id',
        'nationality',
        'certification',
        'profile_pic',
        'basic_salary',
        'commission',
        'duty_start',
        'duty_end',
        'join_date',
        'specialization_id',
        'Establishment_id',
        'facility_type',
        'room_id',
        'period',
        'work_days'
    ];

    protected $dates = ['deleted_at'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'Establishment_id')->where('facility_type', 1);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'Establishment_id')->where('facility_type', 2);
    }


    public function specialization()
    {
        return $this->belongsTo(specialization::class);
    }




    public function appointments()
    {
        return $this->hasMany(appointments::class, 'doctor');
    }



    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}
