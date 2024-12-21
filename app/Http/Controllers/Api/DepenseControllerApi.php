<?php

namespace App\Http\Controllers\Api;

use App\Models\Depense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\DepenseResource;
use App\Http\Requests\DepenseRequest;
use App\Models\User;

class DepenseControllerApi  extends Controller
{
    
    public function index()
    {
        $depenses = Depense::with('categorie')->get();
        return DepenseResource::collection($depenses);
    }

    public function create()
    {
        // Non utilisé dans une API
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function store(DepenseRequest $request)
    {
        $depense = Depense::create($request->validated());
        return response()->json($depense, 201);
        
        //return new DepenseResource($depense);
    }

    public function show(Depense $depense)
    {
        return new DepenseResource($depense);
    }

    public function edit(Depense $depense)
    {
        // Non utilisé dans une API
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function update(DepenseRequest $request, Depense $depense)
    {
        $depense->update($request->validated());
        
        return new DepenseResource($depense);
    }

    public function destroy(Depense $depense)
    {
        $depense->delete();
        
        return response()->json(['message' => 'Depense supprimée avec succès']);
    }
    public function mesdepenses(User $user){
        $depenses = $user->depenses;

        //return response()->json($depenses, 201);
        return DepenseResource::collection($depenses);
        
    }
}