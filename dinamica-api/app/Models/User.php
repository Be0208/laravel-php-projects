<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
        'password' => 'hashed',
    ];

    public static function getPostsAmount($userOrder, $userLimit): array
    {
        return Post::select('users.name', DB::raw('count(userId) as totalPosts'))
            ->join('users', 'users.id', '=', 'posts.userId')
            ->groupBy('users.name')
            ->orderBy('totalPosts', $userOrder === 'asc' ? 'asc' : 'desc')
            ->limit($userLimit === 0 ? 10 : $userLimit)
            ->get()
            ->toArray();
    }

    public function posts() {
        return $this->hasMany(Post::class, 'userId');
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function likes() {
        return $this->hasMany(Like::class, 'userId');
    }

}
