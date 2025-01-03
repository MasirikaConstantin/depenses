<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecurringExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'categorie_id',
                'amount',
        'frequency',
        'next_due_date',
        'notification_id',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
}