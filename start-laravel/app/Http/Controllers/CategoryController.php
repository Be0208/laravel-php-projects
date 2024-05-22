<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = collect($request->query());
        $query = Category::query();

        if($params->get('enable') === "0"){
            $query->NotEnable();
        }

        if($params->get('enable') === null || $params->get('enable') === "1"){
            $query->enable();
        }

        if($params->get('name') !== null){
            $query->FindByName( $params->get('name'));
            // $query->where('name', 'LIKE', '%'. $params->get('name'). '%');
        }

        if($params->get('all') === "1"){
            $query = Category::query();
        }

        $categories = $query->get();

        return response()->json(['success' => true, 'msg' => 'Lista de categorias', 'data' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $category = Category::create($request->all());

            return response()->json(['success'=> true, 'msg' => 'Categoria criada com sucesso.', 'data'=> $category]);

        } catch (\Throwable $th) {
            Log::error('Erro ao criar categoria', ['error' => $th->getMessage()]);
            return response()->json(['success'=> false, 'msg'=> "Erro ao criar categoria."], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['success' => true, 'msg' => "Lita a categoria, $id."]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json(['success' => true, 'msg' => "Edit a categoria, $id."]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json(['success' => true, 'msg' => "Update a categoria, $id."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['success' => true, 'msg' => "Delete a categoria, $id."]);
    }
}
