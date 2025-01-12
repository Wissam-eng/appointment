<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

use Illuminate\Database\Eloquent\Eloquent\softDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class cart extends Model
{
    use HasFactory, HasApiTokens, Notifiable, EloquentSoftDeletes;




    protected $table = 'carts';

    protected $primaryKey = 'id';

    protected $fillable = ['facility_id', 'user_id', 'product_id', 'quantity', 'note' , 'price' , 'total' , 'status'  ,  'latitude',
    'longitude', 'order_number' , 'img'];

    protected $casts = [
        'img' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(profile::class , 'user_id' , 'user_id');
    }


    public function Facility()
    {
        return $this->belongsTo(Facility::class , 'facility_id' , 'id');
    }


    public function stock()
    {
        return $this->belongsTo(stock::class, 'product_id', 'id');
    }


    // protected $casts = [
    //     'product_id' => 'array', // تحويل تلقائي بين JSON ومصفوفة
    // ];

    // // علاقة لاسترجاع المنتجات المرتبطة بالمصفوفة
    // public function stock()
    // {
    //     if (is_array($this->product_id) && !empty($this->product_id)) {
    //         return $this->hasMany(Stock::class, 'id', 'product_id')->whereIn('id', $this->product_id);
    //     }
    
    //     return collect(); // إرجاع مجموعة فارغة إذا كان product_id فارغًا
    // }
    

}
