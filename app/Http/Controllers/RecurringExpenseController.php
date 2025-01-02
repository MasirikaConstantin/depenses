<?php
namespace App\Http\Controllers;

use App\Models\RecurringExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecurringExpenseController extends Controller
{
    // Récupérer toutes les dépenses récurrentes de l'utilisateur
    public function index()
    {
        $user = Auth::user();
        $recurringExpenses = RecurringExpense::where('user_id', $user->id)->get();
        return response()->json($recurringExpenses);
    }

    // Créer une nouvelle dépense récurrente
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'description' => 'required|string',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'frequency' => 'required|string|in:Mensuel,Hebdomadaire,Annuel',
            'next_due_date' => 'required|date',
        ]);

        $recurringExpense = RecurringExpense::create([
            'user_id' => $user->id,
            'description' => $request->description,
            'category' => $request->category,
            'amount' => $request->amount,
            'frequency' => $request->frequency,
            'next_due_date' => $request->next_due_date,
        ]);

        return response()->json($recurringExpense, 201);
    }

    // Récupérer une dépense récurrente spécifique
    public function show($id)
    {
        $user = Auth::user();
        $recurringExpense = RecurringExpense::where('user_id', $user->id)->findOrFail($id);
        return response()->json($recurringExpense);
    }

    // Mettre à jour une dépense récurrente
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
            'amount' => 'sometimes|numeric',
            'frequency' => 'sometimes|string|in:Mensuel,Hebdomadaire,Annuel',
            'next_due_date' => 'sometimes|date',
        ]);

        $recurringExpense = RecurringExpense::where('user_id', $user->id)->findOrFail($id);
        $recurringExpense->update($request->all());

        return response()->json($recurringExpense);
    }

    // Supprimer une dépense récurrente
    public function destroy($id)
    {
        $user = Auth::user();
        $recurringExpense = RecurringExpense::where('user_id', $user->id)->findOrFail($id);
        $recurringExpense->delete();

        return response()->json(null, 204);
    }
}