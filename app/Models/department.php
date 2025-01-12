<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class department extends Model
{
    use HasFactory , HasApiTokens , Notifiable , EloquentSoftDeletes;

    protected $table = 'departments';

    protected $primaryKey = 'id';

    protected $fillable = ['dep_name' ];

    protected $dates = ['deleted_at'];
}
