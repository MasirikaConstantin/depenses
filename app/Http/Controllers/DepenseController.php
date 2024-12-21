<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use App\Http\Resources\DepenseResource;
use App\Http\Requests\DepenseRequest;

class DepenseController extends Controller
{
    public function index()
    {
        $depenses = Depense::all();
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
        
        return new DepenseResource($depense);
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
}