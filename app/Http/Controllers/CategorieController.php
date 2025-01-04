<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::paginate(10);
        return view('categorie.index',['categories'=>$categories]);
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
    public function store(Request $request)
    {
        //
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
    public function edit(Categorie $category)
    {
        return view('categorie.categorienew',['categorie'=>$category]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $category)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);
       // $data = $validated->validated();
        //dd($validated);
        $category->update($validated);
        return back()->with("success","Categorie modifiée avec success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $category)
    {
        $category->delete();
        return back()->with("success", "Categorie supprimée avec success");

    }

    public function toggleStatus($id)
    {
        $category = Categorie::findOrFail($id);
        $category->status = $category->status === 1 ? 0 : 1; // Basculer entre actif (0) et inactif (1)
        $category->save();
    
        return redirect()->back()->with('success', 'État de l\'utilisateur mis à jour.');
    }
}
