<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image',
        'skills',
        'experience',
        'project_budget',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
             'password'          => 'hashed',
             'role'              => UserRole::class,
        ];
    }

    public function isAdmin() : bool
    {
        return $this->role === UserRole::ADMIN;
    }

     public function isFreelancer() : bool
     {
          return $this->role === UserRole::FREELANCER;
     }

     public function isClient() : bool
     {
          return $this->role === UserRole::CLIENT;
     }

     public function getDefaultRoute() : string
     {
          return  match (auth()->user()->role) {
               UserRole::ADMIN      => route('admin.dashboard'),
               UserRole::FREELANCER => route('freelancer.dashboard'),
               UserRole::CLIENT     => route('client.dashboard'),
          };

     }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    /**
     * Messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    /**
     * Messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    // Calculate the average rating for a freelancer
    public function averageRating()
    {
        return $this->hasMany(Rating::class, 'freelancer_id')->avg('rating');
    }

    // Display total number of ratings
    public function totalRatings()
    {
        return $this->hasMany(Rating::class, 'freelancer_id')->count();
    }

    public function reviews()
    {
        return $this->hasMany(Rating::class, 'freelancer_id');
    }
}
