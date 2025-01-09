<?php

namespace App\Http\Controllers\Api;

use App\Models\Entre;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntreValidator;
use App\Http\Resources\EntreRessource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entre = Entre::all();
        return EntreRessource::collection($entre);

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
    public function store(EntreValidator $request)
    {
        $entre = Entre::create($request->validated());
        return response()->json($entre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entre $entre)
    {
        return new EntreRessource($entre);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entre $entre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntreValidator $request, Entre $entre)
    {
        $entre->update($request->validated());
        
        return new EntreRessource($entre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entre $entre)
    {
        $entre->delete();
        
        return response()->json(['message' => 'L\'entrée supprimée avec succès']);
    }
    public function mesentrees(User $user){
        $entres = Entre::where('user_id', $user->id)
        ->orderBy('date', 'desc')
        ->get();

    if ($entres->isEmpty()) {
        return response()->json([
            'entres' => collect(),
            'dailyTotals' => collect(),
        ]);
    }

    // Grouper les dépenses par date
    $depensesGrouped = $entres->groupBy(function($date) {
        return Carbon::parse($date->date)->format('Y-m-d');
    }); // Inverser les groupes

    // Réorganiser chaque groupe pour afficher en premier l'élément avec `id = 307`
    $depensesGrouped = $depensesGrouped->map(function ($group) {
        $specificId = 307; // ID à afficher en premier
        return $group->sortByDesc(function ($item) use ($specificId) {
            return $item->id === $specificId ? PHP_INT_MAX : $item->id;
        })->values(); // Réindexer le tableau
    });

    // Calcul des totaux journaliers
    $dailyTotals = $depensesGrouped->map(function($group) {
        return $group->sum('montant');
    });

    return response()->json([
        'Entrergrouper' =>($depensesGrouped),
        'dailyTotals' => $dailyTotals,
    ]);
    }
}
