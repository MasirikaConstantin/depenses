<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRecurringExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('recurring_expenses', function (Blueprint $table) {
            $table->dropColumn('category'); // Supprimer l'ancien champ
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Ajouter la clé étrangère
        });
    }

    public function down()
    {
        Schema::table('recurring_expenses', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // Supprimer la clé étrangère
            $table->string('category'); // Restaurer l'ancien champ
        });
    }
}