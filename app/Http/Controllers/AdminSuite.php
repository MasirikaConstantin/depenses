<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminSuite extends Controller
{
    
    public function index(){
        return view('admin.index',['users'=>User::all()]);
    }
    

    /**
     * Affiche le formulaire de création d'un administrateur.
     */
    public function create()
    {
        return view('admin.create',['user'=>new User()]);
    }

    /**
     * Gère la création d'un administrateur.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'etat' => 'nullable|boolean',
        ]);

        try {
            User::create([
                'email' => $validated['email'],
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'etat' => $validated['etat'] ?? 0, // Défaut : non actif
            ]);

            return redirect()->route('admin.create')->with('success', 'Administrateur créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la création de l\'administrateur : ' . $e->getMessage()]);
        }
    }
    
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->etat = $user->etat === 0 ? 1 : 0; // Basculer entre actif (0) et inactif (1)
        $user->save();
    
        return redirect()->back()->with('success', 'État de l\'utilisateur mis à jour.');
    }

    public function show(String $user){
         $utilisateur = User::find($user); // Remplacez $id par l'identifiant de l'utilisateur
           // dd($);
         return view('admin.create',['user' => $utilisateur]);
     }

     public function update(String $user , Request $request){
        $utilisateur = User::find($user); // Remplacez $id par l'
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'. $utilisateur->id,
            'password' => 'nullable|string|min:6',
        ]);
    
        // Mettre à jour les informations de l'utilisateur
        $utilisateur->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $utilisateur->password,
        ]);
    
       
        return redirect()->route('admin.index')->with('success', 'Utilisateur  mis à jour avec succès.');
    
    }
}
