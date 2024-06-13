<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $posts = Post::with('likes')->with('likes.user')->get();

        return response()->json(['success' => true, 'data' => $posts]);
    }

       public function store(Request $request)
    {
        try {

            $user = Auth::user();

            $request->validate([
                'content' => 'required'
            ],
            [
                'required' => 'O campo :attribute é obrigatório.'
            ]);

            $post = Post::create([
                "userId" => $user->id,
                "content" => $request->content
            ]);

            if($request->tags){
                $post->tags()->attach($request->tags);
            }

            return response()->json(['success' => true, 'msg' => 'Post cadastrado com sucesso!', 'data' => $post]);
        } catch (\Throwable $th) {
            return response()->json(['success' => true, 'msg' => $th->getMessage()], 400);
        }
    }

       public function show(string $id)
    {
        {
            £
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $post = Post::findOrFail($id);

            $request->validate([
                'content' => 'required'
            ],
            [
                'required' => 'Faltou :attribute'
            ]);

            if($request->tags){
                $post->tags()->sync($request->tags);
            } else {
                $post->tags()->detach();
            }

            $post->content = $request->content;
            $post->save();
            return response()->json(['success' => true, 'msg' => 'Post editado com sucesso!', 'data' => $post]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage], 400);
        }
    }

    public function destroy(string $id)
    {
        try {

            $post = Post::findOrFail($id);

            $post->delete();
            return response()->json(['success' => true, 'msg' => 'Post nº ' . $id . ' excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage], 400);
        }
    }
}
