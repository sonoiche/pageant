<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $appends = ['fullname','display_photo'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullnameAttribute()
    {
        $fname = $this->attributes['fname'] ?? '';
        $lname = $this->attributes['lname'] ?? '';
        if($fname && $lname) {
            return $fname.' '.$lname;
        }

        return '';
    }

    public function getDisplayPhotoAttribute()
    {
        $fname = $this->attributes['fname'] ?? '';
        $lname = $this->attributes['lname'] ?? '';
        if($fname && $lname) {
            $fullname = $fname.' '.$lname;
            return 'https://ui-avatars.com/api/?name='.$fullname.'&background=random';
        }

        return '';
    }
}
