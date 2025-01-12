<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\ResetPasswordNotification;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, EloquentSoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'facility_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // دالة للتحقق من صلاحية التوكين
    public function tokenIsExpired()
    {
        $token = $this->tokens()->latest('created_at')->first();
        if ($token) {
            $expiry = $token->expires_at;
            return Carbon::now()->greaterThan($expiry);
        }
        return true;
    }


    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($facility) {
            if ($facility->isForceDeleting()) {
                $facility->cart()->forceDelete();
            } else {
                $facility->cart()->delete();
            }
        });

        static::restoring(function ($facility) {
            $facility->cart()->withTrashed()->restore();
        });
    }




    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function profile()
    {
        return $this->hasOne(profile::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }


    public function appointments()
    {
        return $this->hasMany(appointments::class, 'user_id');
    }
}
