<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        $userOrder = $request->query('order'); // Url: http://localhost:8000/api/reports?order=asc
        $userLimit = (int) $request->query('limit'); // Url: http://localhost:8000/api/reports?limit=5
        $isPosts = $request->query('posts'); // Url: http://localhost:8000/api/reports?posts=1

        if ($isPosts === '1') {
            $posts = Post::getPostLikes($userOrder, $userLimit);

            return response()->json([
                'postsLikes' => $posts
            ]);
        }

        $users = User::getPostsAmount($userOrder, $userLimit);

        return response()->json(
            [
                'usersPostsAmount' => $users
            ]
        );
    }



    public function user()
    {
        $posts = Post::select('userId', DB::raw('count(userId) as totalPosts'))
            ->groupBy('userId')
            ->orderBy('totalPosts', 'desc')
            ->limit(10)
            ->get();

        $users_id = $posts->map(function ($post) {
            return $post->userId;
        });

        $users = User::whereIn('id', $users_id)->get();

        $usersWithPosts = $users->map(function ($user) use ($posts) {
            $postObj = $posts->filter(function ($post) use ($user) {
                return $post->userId === $user->id;
            });

            $user->total_posts = array_values($postObj->toArray())[0]['totalPosts'];
            return $user;
        });

        $orderData = collect($usersWithPosts)->sortByDesc('totalPosts')->toArray();

        return response()->json([
            'report_users' => [...$orderData]
        ]);
    }
}
