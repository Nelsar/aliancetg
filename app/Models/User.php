<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email', 
        'email_verified_at', 
        'password', 
        'remember_token', 
        'created_at', 
        'timestamp', 
        'updated_at', 
        'timestamp',
        'phone',  
        'phone_invite', 
        'iin', 
        'last_name', 
        'patronymic', 
        'birthday', 
        'date', 
        'status', 
        'refferal_code', 
        'parent_id', 
        'admin_id', 
        'balance' 
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'updated_at' => 'datetime',
            'timestamp' => 'datetime',
            'birthday' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
