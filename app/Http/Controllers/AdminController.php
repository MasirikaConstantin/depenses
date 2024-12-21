<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $montantTotal = $this->getMontantTotalDuJour();
        
        $recentActivities = Depense::with('user')->orderByDesc('id')->limit(5)->get();

            return view('dashboard',[
                'montantTotal' => $montantTotal,
                "totalAgents" => User::count(),
                'recentActivities' => $recentActivities

            ] );
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

   

    public function getMontantTotalDuJour()
    {
        $aujourdhui = Carbon::now()->toDateString(); // Obtient la date actuelle au format 'YYYY-MM-DD'
        
        $montantTotal = Depense::whereDate('date', $aujourdhui)->sum('montant');

        return $montantTotal;
    }

    
}
