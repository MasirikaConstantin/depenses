<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom', 'description',"status"];
    public function recurringExpenses()
    {
        return $this->hasMany(RecurringExpense::class);
    }
}
