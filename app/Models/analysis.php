<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class analysis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'analyses';
    protected $primaryKey = 'id';
    protected $fillable = ['analysis_name', 'analysis_pic' , 'facility_id' , 'number_of_days' ];


    public function facility()
    {
        return $this->belongsTo(Facility::class , 'facility_id');
    }

}
