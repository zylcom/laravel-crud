<?php

namespace App\Models;

use App\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
/*use Illuminate\Database\Eloquent\Relations\MorphMany;*/
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
            'email_verified_at' => 'datetime:D, d M Y',
            'password' => 'hashed',
            'role' => UserRole::class,
            'created_at' => 'datetime:D, d M Y',
            'updated_at' => 'datetime:D, d M Y',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /*public function notifications(): MorphMany*/
    /*{*/
    /*    return $this->morphMany(Notification::class, 'notifiable');*/
    /*}*/

    /*public function productable()*/
    /*{*/
    /*    return $$this->morphMany(Product::class, 'productable');*/
    /*}*/
}
