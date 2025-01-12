<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class operations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $fillable = ['operation_name', 'operation_pic', 'facility_id' , 'specialization_id'];


    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }


    public function specialization()
    {
        return $this->belongsTo(specialization::class, 'specialization_id');
    }

}
