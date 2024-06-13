<?php

namespace App\Services;

use App\Models\Post;

class ReportService {
    public static function postsByUser($userId){
        return Post::where('userId', $userId)->get();
    }

    public static function postsMostLikes($limit=1){
        $query = Post::withCount('likes')->orderBy('likes_count', 'desc')->limit($limit)->get();

        return $query;
    }

    public static function postsByTag($tagId){
        return Post::whereHas('tags', function($query) use ($tagId){
            $query->where('tag_id', $tagId);
        })->get();
    }
}
