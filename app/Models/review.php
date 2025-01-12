<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $fillable = [ 'facility_id' , 'comment' , 'review' , 'client_id'];


    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    
    
}
