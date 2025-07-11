<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function password(): Attribute       // This is a user field, camel case if it is compound
    {
        return Attribute::make(                     // This is a new PHP (>=8) feature called Name Attributes
            get: fn (string $value) => $value,      // This is a shorthand fn for function and => arrow function
            set: fn (string $value) => Hash::make($value)
        );
    }

    public function listings(): HasMany
    {
        return $this->hasMany(
            \App\Models\Listing::class,     // This returns a Collection, a special Laravel wrapper for arrays
            'by_user_id'
        );
    }
}
