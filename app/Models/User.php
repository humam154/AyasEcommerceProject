<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'gender',
        'birth_date',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function userLocations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }

    public function givenRatings(): HasMany
    {
        return $this->hasMany(UserRate::class, 'rater_id');
    }

    public function receivedRatings(): HasMany
    {
        return $this->hasMany(UserRate::class, 'rated_id');
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class, 'user_id');
    }

    public function adverts(): HasMany
    {
        return $this->hasMany(Advert::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
}
