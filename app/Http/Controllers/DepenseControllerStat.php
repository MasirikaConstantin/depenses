<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Depense;
use App\Models\User;
use Carbon\Carbon;

class DepenseControllerStat extends Controller
{
    /**
     * Récupère les dépenses par catégorie.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepensesParCategorie(User $user)
    {
        $depensesParCategorie = DB::table('depenses')
            ->join('categories', 'depenses.categorie_id', '=', 'categories.id')
            ->where('depenses.user_id', $user->id)
            ->select('categories.nom as categorie', DB::raw('SUM(depenses.montant) as total'))
            ->groupBy('categories.nom')
            ->get();

        return response()->json($depensesParCategorie);
    }

    /**
     * Récupère les dépenses par jour.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepensesParJour(User $user)
    {
        $depensesParJour = DB::table('depenses')
            ->where('user_id', $user->id)
            ->select(DB::raw('DATE(depenses.date) as jour'), DB::raw('SUM(depenses.montant) as total'))
            ->groupBy('jour')
            ->orderBy('jour', 'asc')
            ->get();

        return response()->json($depensesParJour);
    }

    /**
     * Récupère les dépenses par mois.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepensesParMois(User $user)
    {
        $depensesParMois = DB::table('depenses')
            ->where('user_id', $user->id)
            ->select(DB::raw("strftime('%Y-%m', date) as mois"), DB::raw('SUM(montant) as total'))
            ->groupBy('mois')
            ->orderBy('mois', 'asc')
            ->get();

        return response()->json($depensesParMois);
    }


// Dans votre contrôleur (par exemple, DepenseController.php)
public function getDepensesParSemaine($userId, Request $request)
{
    $request->validate([
        'month' => 'required|integer|between:1,12',
        'year' => 'required|integer',
    ]);

    $month = $request->input('month');
    $year = $request->input('year');

    // Récupérer les dépenses du mois et de l'année donnés pour l'utilisateur spécifié
    $depenses = Depense::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->where('user_id', $userId) // Filtrer par utilisateur
        ->get();

    // Grouper les dépenses par semaine
    $weeks = [];
    $startOfMonth = Carbon::create($year, $month, 1);
    $endOfMonth = $startOfMonth->copy()->endOfMonth();

    $currentWeek = 1;
    $startOfWeek = $startOfMonth->copy()->startOfWeek();
    $endOfWeek = $startOfWeek->copy()->endOfWeek();

    while ($startOfWeek->lte($endOfMonth)) {
        $total = $depenses->whereBetween('date', [$startOfWeek, $endOfWeek])->sum('montant');

        $weeks[] = [
            'week' => $currentWeek,
            'start_date' => $startOfWeek->toDateString(),
            'end_date' => $endOfWeek->toDateString(),
            'total' => $total,
        ];

        $currentWeek++;
        $startOfWeek->addWeek();
        $endOfWeek->addWeek();
    }

    return response()->json([
        'month' => $month,
        'year' => $year,
        'weeks' => $weeks,
    ]);
}

// Dans votre contrôleur (par exemple, DepenseController.php)
public function getMoyenneDepensesParJour($userId)
{
    $year = Carbon::now()->year;

    $results = [];
    for ($month = 1; $month <= 12; $month++) {
        $totalDepenses = Depense::whereYear('date', $year)
            ->whereMonth('date', $month)
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