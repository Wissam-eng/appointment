<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Profile extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;



    protected $table = 'profiles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
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
        'profile_pic'
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    

}
