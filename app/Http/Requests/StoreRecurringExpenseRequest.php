<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecurringExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required|string',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'frequency' => 'required|string|in:Mensuel,Hebdomadaire,Annuel',
            'next_due_date' => 'required|date',
        ];
    }
}