<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hospital_specializations extends Model
{
    use HasFactory;
    protected $table = 'hospital_specializations';
    protected $primaryKey = 'id';
    protected $fillable = ['hospital_name', 'hospital_address', 'mobile', 'specialization' , 'profile_pic' , 'room_num'];

}
