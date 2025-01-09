<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearEntresAndDepensesSeeder extends Seeder
{
    /**
     * Exécute le seeder.
     *
     * @return void
     */
    public function run()
    {
        // Vérifier le type de base de données
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'sqlite') {
            // Désactiver les clés étrangères pour SQLite
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            // Désactiver les clés étrangères pour MySQL/MariaDB
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // Vider la table `entres`
        DB::table('entres')->truncate();

        // Vider la table `depenses`
        DB::table('depenses')->truncate();

        if ($driver === 'sqlite') {
            // Réactiver les clés étrangères pour SQLite
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            // Réactiver les clés étrangères pour MySQL/MariaDB
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('Les tables `entres` et `depenses` ont été vidées avec succès.');
    }
}