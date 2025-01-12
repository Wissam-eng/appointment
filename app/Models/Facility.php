<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

class Facility extends Model
{
    use HasFactory, EloquentSoftDeletes;

    protected $table = 'facilities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'address',
        'mobile',
        'mobile1',
        'mobile2',
        'mobile3',
        'mobile4',
        'profile_pic',
        'room_num',
        'facility_type',
        'email',
        'website',
        'opening_hours',
        'description',
        'latitude',
        'longitude',
        'status',
        'facility_class',
        'manager_id',
        'capacity',
        'services',
        'license_number',
        'Suggested',
        'established_at',
        'ambulance',
        'emergency',
    ];

    protected $dates = ['deleted_at', 'established_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($facility) {
            $relations = ['doctors', 'user', 'employees', 'rooms_type', 'rooms', 'appointments', 'analysis', 'categories', 'stock', 'cart', 'views'];
            foreach ($relations as $relation) {
                if ($facility->isForceDeleting()) {
                    $facility->$relation()->forceDelete();
                } else {
                    $facility->$relation()->delete();
                }
            }
        });

        static::restoring(function ($facility) {
            $relations = ['doctors', 'user', 'employees', 'rooms_type', 'rooms', 'appointments', 'analysis', 'categories', 'stock', 'cart', 'views'];
            foreach ($relations as $relation) {
                $facility->$relation()->withTrashed()->restore();
            }
        });
    }

    public function doctors()
    {
        return $this->hasMany(Doctors::class, 'Establishment_id', 'id');
    }



    public function user()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(Doctors::class, 'Establishment_id', 'id');
    }


    public function rooms_type()
    {
        return $this->belongsTo(room_types::class);
    }



    public function rooms()
    {
        return $this->hasMany(room::class, 'facility_id', 'id');
    }





    public function appointments()
    {
        return $this->hasMany(appointments::class);
    }

    public function analysis()
    {
        return $this->belongsTo(analysis::class);
    }


    public function categories()
    {
        return $this->hasMany(categorys::class);
    }

    public function stock()
    {
        return $this->hasMany(stock::class);
    }



    public function cart()
    {
        return $this->hasMany(cart::class);
    }


    public function views()
    {
        return $this->hasMany(review::class, 'facility_id');
    }
}
