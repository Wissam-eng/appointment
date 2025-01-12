<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class rate extends Model
{
    use HasFactory , HasApiTokens , Notifiable , EloquentSoftDeletes;


    
    protected $table = 'rates';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'facility_id',
        'doctor_id',
        'rate',
        'comment',
        'date_rated'

    ];



    public function doctor()
    {
        return $this->belongsTo(Doctors::class , 'doctor_id');
    }
    

}
