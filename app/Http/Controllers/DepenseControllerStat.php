<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Depense;

class DepenseControllerStat extends Controller
{
    /**
     * Récupère les dépenses par catégorie.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepensesParCategorie()
    {
        $depensesParCategorie = DB::table('depenses')
            ->join('categories', 'depenses.categorie_id', '=', 'categories.id')
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
    public function getDepensesParJour()
    {
        $depensesParJour = DB::table('depenses')
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
    public function getDepensesParMois()
{
    $depensesParMois = DB::table('depenses')
        ->select(DB::raw("strftime('%Y-%m', date) as mois"), DB::raw('SUM(montant) as total'))
        ->groupBy('mois')
        ->orderBy('mois', 'asc')
        ->get();

    return response()->json($depensesParMois);
}
}