<?php

namespace App\Http\Controllers\Api;

use App\Models\Entre;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntrerUpdate;
use App\Http\Requests\EntreValidator;
use App\Http\Resources\EntreRessource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function update(EntrerUpdate $request, Entre $entre)
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

    public function mesentresjournaliere($id)
{
    $user = User::findOrFail($id);
    $today = Carbon::now()->format('Y-m-d');

    $depenses = Entre::with(['user'])
        ->where('user_id', $id)
        ->whereDate('created_at', $today)
        ->orderBy('created_at', 'desc')
        ->get();

    if ($depenses->isEmpty()) {
        return EntreRessource::collection(collect())->additional([
            'totalJournalier' => 0
        ]);
    }

    // Réorganiser pour afficher en premier l'élément avec `id = 307`
    $depensesTriees = $depenses->sortByDesc(function ($item) {
        return $item->id === 307 ? PHP_INT_MAX : $item->id;
    })->values();

    // Calcul du total journalier
    $totalJournalier = $depenses->sum('montant');

    return EntreRessource::collection($depensesTriees)->additional([
        'totalJournalier' => $totalJournalier
    ]);
}

public function getEntresParJour(User $user)
{
    $depensesParJour = DB::table('depenses')
        ->where('user_id', $user->id)
        ->select(DB::raw('DATE(depenses.date) as jour'), DB::raw('SUM(depenses.montant) as total'))
        ->groupBy('jour')
        ->orderBy('jour', 'asc')
        ->get();

    return response()->json($depensesParJour);
}
public function getEntresParMois(User $user)
    {
        $depensesParMois = DB::table('entres')
            ->where('user_id', $user->id)
            ->select(DB::raw("strftime('%Y-%m', created_at) as mois"), DB::raw('SUM(montant) as total'))
            ->groupBy('mois')
            ->orderBy('mois', 'asc')
            ->get();

        return response()->json($depensesParMois);
    }


    public function getEntresParSemaine($userId, Request $request)
{
    // Validation des entrées
    $request->validate([
        'month' => 'required|integer|between:1,12',
        'year' => 'required|integer',
    ]);

    $month = $request->input('month');
    $year = $request->input('year');

    // Récupérer les entrées du mois et de l'année donnés pour l'utilisateur spécifié
    $entres = Entre::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->where('user_id', $userId)
        ->get();

    // Grouper les entrées par semaine
    $weeks = [];
    $startOfMonth = Carbon::create($year, $month, 1); // Début du mois
    $endOfMonth = $startOfMonth->copy()->endOfMonth(); // Fin du mois

    // Trouver le premier lundi du mois ou commencer au premier jour du mois
    $firstMonday = $startOfMonth->copy()->startOfWeek();

    // Si le premier lundi est dans le mois précédent, commencez au premier jour du mois
    if ($firstMonday->month != $month) {
        $firstMonday = $startOfMonth;
    }

    $currentWeek = 1;
    $startOfWeek = $firstMonday;

    do {
        $endOfWeek = $startOfWeek->copy()->addDays(6); // Ajoute 6 jours pour avoir une semaine complète

        // Filtrer les entrées pour la semaine en cours
        $total = $entres->filter(function ($entre) use ($startOfWeek, $endOfWeek) {
            $createdAt = Carbon::parse($entre->created_at);
            return $createdAt->between($startOfWeek, $endOfWeek);
        })->sum('montant');

        // N'ajouter la semaine que si elle chevauche le mois demandé
        if ($startOfWeek->lte($endOfMonth) && $endOfWeek->gte($startOfMonth)) {
            $weeks[] = [
                'week' => $currentWeek,
                'start_date' => $startOfWeek->toDateString(),
                'end_date' => $endOfWeek->toDateString(),
                'total' => $total,
            ];
            $currentWeek++;
        }

        // Passer à la semaine suivante
        $startOfWeek->addDays(7);
    } while ($startOfWeek->lte($endOfMonth));

    // Retourner la réponse JSON
    return response()->json([
        'month' => $month,
        'year' => $year,
        'weeks' => $weeks,
        //"entres" => $entres,
    ]);
}


public function getMoyenneEntresParJour($userId)
{
    $year = Carbon::now()->year;

    $results = [];
    for ($month = 1; $month <= 12; $month++) {
        $totalDepenses = Entre::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('user_id', $userId) // Filtrer par utilisateur
            ->sum('montant');

        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $averagePerDay = $daysInMonth > 0 ? $totalDepenses / $daysInMonth : 0;

        $results[] = [
            'month' => $month,
            'month_name' => Carbon::create()->month($month)->locale('fr')->monthName,
            'average_per_day' => round($averagePerDay, 2),
        ];
    }

    return response()->json($results);
}
}

