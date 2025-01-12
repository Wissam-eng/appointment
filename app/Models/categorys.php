<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class categorys extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;

    protected $table = 'categorys';

    protected $primaryKey = 'id';

    protected $fillable = [
        'category_name',
        'category_type',
        'img',

        'facility_id'
    ];

    public function products()
    {
        return $this->hasMany(stock::class , 'category_id', 'id');
    }
}
