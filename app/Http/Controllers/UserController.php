<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidator;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        // UserController.php
public function index()
{
    $dateAujourdhui = Carbon::now()->toDateString();
    $dateSemaineDerniere = Carbon::now()->subWeek()->toDateString();

    $utilisateurs = User::with(['depenses' => function ($query) use ($dateAujourdhui, $dateSemaineDerniere) {
        $query->with('categorie')
              ->whereDate('date', '>=', $dateSemaineDerniere)
              ->whereDate('date', '<=', $dateAujourdhui);
    }])->get();

    foreach ($utilisateurs as $utilisateur) {
        // Dépenses du jour
        $depensesJour = $utilisateur->depenses->filter(function($depense) use ($dateAujourdhui) {
            return Carbon::parse($depense->date)->toDateString() === $dateAujourdhui;
        });
        
        // Dépenses de la semaine
        $depensesSemaine = $utilisateur->depenses;

        $utilisateur->depenses_jour = $depensesJour;
        $utilisateur->total_jour = $depensesJour->sum('montant');
        $utilisateur->total_semaine = $depensesSemaine->sum('montant');
        $utilisateur->moyenne_jour = $depensesSemaine->count() > 0 
            ? $depensesSemaine->sum('montant') / 7 
            : 0;
    }

    $totalGeneral = $utilisateurs->sum('total_jour');

    return view('users.index', [
        'users' => $utilisateurs,
        'totalGeneral' => $totalGeneral,
        'date' => Carbon::now()->format('d/m/Y')
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create',["user"=>new User()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserValidator $request)
    {
        User::create($this->extractData(new User() ,$request));
        


            return redirect()->route('users.create')
                ->with('success', 'Utilisateur créé avec succès.');
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
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if (Auth::user()->id === $user->id) {
            return redirect(route("users.index"))->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        //dd($user);

        $userName = $user->name;
        $user->delete();

        return redirect(route("users.index"))->with('success', "L'utilisateur {$userName} a été supprimé avec succès.");
    
    }

    private function extractData(User $user,  Request $request){

        $validated =$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',

            'image'=> ["nullable",'max:5120', 'mimes:png,jpg,jpeg,gif,PNG,JPEG,JPG'],

        ]);
        $data=[
            'name' => $validated['name'],
            'image' => $validated['image'] ?? '',
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ];
        //dd($data);
        /**
        * @var UploadedFile $image
         */
        $image=$data['image'];
        if($image==null || $image->getError()){
            return $data;
        }
        if($user->image){
            Storage::disk('public')->delete($user->image);
        }
            $data['image']=$image->store("profil",'public');
        return $data;
    }


    public function voir($id)
{
    $user = User::findOrFail($id);
    
    $depenses = Depense::with(['user', 'categorie'])
        ->where('user_id', $id)
        ->orderBy('date', 'desc')
        ->get();

    if ($depenses->isEmpty()) {
        return view('users.voir', [
            'user' => $user,
            'depenses' => collect(),
            'dailyTotals' => collect()
        ]);
    }

    $depensesGrouped = $depenses->groupBy(function($date) {
        return Carbon::parse($date->date)->format('Y-m-d');
    });

    $dailyTotals = $depensesGrouped->map(function($group) {
        return $group->sum('montant');
    });

    return view('users.voir', compact('user', 'depensesGrouped', 'dailyTotals'));
}
    
}
