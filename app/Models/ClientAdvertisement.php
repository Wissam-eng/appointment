<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ClientAdvertisement extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;
    protected $table = 'client_advertisements';

    protected $primaryKey = 'id';

    protected $fillable = ['title','content' ,'image_url' , 'ad_type','start_date','end_date','status', 'created_by' , 'client_id' , 'cost'];


    public function client()
    {
        return $this->belongsTo(Facility::class, 'client_id', 'id');
    }

}
