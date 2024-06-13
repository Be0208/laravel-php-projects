<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = [
        'userId',
        'content'
    ];

    protected $with = ['user', 'tags'];

    public static function getPostLikes($userOrder, $userLimit): array
    {
        return Like::select('posts.id', 'posts.content', 'users.name', DB::raw('count(postId) as totalLikes'))
            ->join('posts', 'posts.id', '=', 'likes.postId')
            ->join('users', 'users.id', '=', 'posts.userId')
            ->groupBy('posts.id', 'posts.content', 'users.name')
            ->orderBy('totalLikes', $userOrder === 'asc' ? 'asc' : 'desc')
            ->limit($userLimit === 0 ? 10 : $userLimit)
            ->get()
            ->toArray();
    }

    public function user() {
        return $this->belongsTo(User::class, 'userId');
    }

    public function likes(){
        return $this->hasMany(Like::class, 'postId');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
