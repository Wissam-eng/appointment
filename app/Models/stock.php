<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class stock extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;


    protected $table = 'stock';

    protected $primaryKey = 'id';

    protected $fillable = ['product_name', 'product_img', 'product_type', 'note', 'qty', 'price', 'exp_date', 'facility_id' , 'category_id'];

    protected $dates = ['deleted_at'];


    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }


    public function cart()
    {
        return $this->belongsTo(cart::class);
    }
    public function categorys()
    {
        return $this->belongsTo(categorys::class);
    }
}
