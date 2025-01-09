<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearEntresAndDepensesSeeder extends Seeder
{
    /**
     * Exécute le seeder.
     *
     * @return void
     */
    public function run()
    {
        // Désactiver les contraintes de clé étrangère temporairement
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Vider la table `entres`
        DB::table('entres')->truncate();

        // Vider la table `depenses`
        DB::table('depenses')->truncate();

        // Réactiver les contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Les tables `entres` et `depenses` ont été vidées avec succès.');
    }
}