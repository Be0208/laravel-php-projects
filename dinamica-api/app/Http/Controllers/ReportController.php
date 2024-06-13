<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $report = $request->report;

        switch ($report) {
            case 'user':
                $userId = $request->query('userId');
                $posts = ReportService::postsByUser($userId);
                return response()->json(['success' => true, 'msg'=>'Relatório retornado com sucesso.', 'data' => $posts]);
                break;
            case 'most-likes':
                $limit = $request->query('limit');
                $posts = ReportService::postsMostLikes($limit);
                return response()->json(['success' => true, 'msg'=>'Relatório retornado com sucesso.', 'data' => $posts]);
            case 'tag':
                $tagId = $request->query('tagId');
                $posts = ReportService::postsByTag($tagId);
                return response()->json(['success' => true, 'msg'=>'Relatório retornado com sucesso.', 'data' => $posts]);
            default:
                return response()->json(['success' => false, 'msg'=>'Relatório não encontrado.'], 400);
                break;
        }

    }

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
