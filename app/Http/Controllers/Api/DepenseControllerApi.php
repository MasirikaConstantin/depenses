<?php

namespace App\Http\Controllers\Api;

use App\Models\Depense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\DepenseResource;
use App\Http\Requests\DepenseRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;

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
    public function mesdepensess(User $user){
        $depenses = $user->depenses;

        //return response()->json($depenses, 201);
        return DepenseResource::collection($depenses);
        
    }
    public function mesdepenses($id)
{
    $user = User::findOrFail($id);

    $depenses = Depense::with(['user', 'categorie'])
        ->where('user_id', $id)
        ->orderBy('date', 'desc')
        ->get();

    if ($depenses->isEmpty()) {
        return response()->json([
            'user' => new UserResource($user),
            'depenses' => collect(),
            'dailyTotals' => collect(),
        ]);
    }

    // Grouper les dépenses par date
    $depensesGrouped = $depenses->groupBy(function($date) {
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
        'user' => new UserResource($user),
        'depensesGrouped' => $depensesGrouped,
        'dailyTotals' => $dailyTotals,
    ]);
}

public function mesdepensesjournaliere($id)
{
    $user = User::findOrFail($id);
    $today = Carbon::now()->format('Y-m-d');

    $depenses = Depense::with(['user', 'categorie'])
        ->where('user_id', $id)
        ->whereDate('date', $today)
        ->orderBy('date', 'desc')
        ->get();

    if ($depenses->isEmpty()) {
        return response()->json([
            'user' => new UserResource($user),
            'depenses' => collect(),
            'totalJournalier' => 0,
        ]);
    }

    // Réorganiser pour afficher en premier l'élément avec `id = 307`
    $depensesTriees = $depenses->sortByDesc(function ($item) {
        return $item->id === 307 ? PHP_INT_MAX : $item->id;
    })->values();

    // Calcul du total journalier
    $totalJournalier = $depenses->sum('montant');

    return response()->json([
        'user' => new UserResource($user),
        'depenses' => $depensesTriees,
        'totalJournalier' => $totalJournalier,
    ]);
}

 /*return response()->json([
        'user' => new UserResource($user),
        'depensesGrouped' => $depensesGrouped->map(function ($items) {
            return DepenseResource::collection($items);
        }),
        'dailyTotals' => $dailyTotals,
    ]);*/
//    return view('users.voir', compact('user', 'depensesGrouped', 'dailyTotals'));
}