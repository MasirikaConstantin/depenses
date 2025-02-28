<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorieRequest;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\Categorieressource;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorie =Categorie::where("status", 1)->get();
        return Categorieressource::collection($categorie);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request)
    {
        $categorie = Categorie::create($request->validated());
        return response()->json($categorie, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
    }
}
