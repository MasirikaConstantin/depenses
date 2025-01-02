<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recurring_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table users
            $table->string('description');
            $table->string('category');
            $table->decimal('amount', 10, 2); // Montant avec 2 décimales
            $table->string('frequency'); // Fréquence (Mensuel, Hebdomadaire, Annuel)
            $table->date('next_due_date'); // Prochaine date d'échéance
            $table->string('notification_id')->nullable(); // Identifiant de la notification
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_expenses');
    }
};
