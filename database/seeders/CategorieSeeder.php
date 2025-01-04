<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        function generateRandomString($length = 10) {
            $characters = ' abcdefghijklmnopqr stuvwxyzABCDEFGHIJK LMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        
        for ($i = 0; $i < 15; $i++) {
            \Illuminate\Support\Facades\DB::table('categories')->insert([
                "nom" => generateRandomString(10),
                "description" => generateRandomString(15), // Chaîne aléatoire de 15 caractères
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }*/

        $categories = [
            ['nom' => 'Alimentation', 'description' => 'Dépenses liées à la nourriture et aux courses'],
            ['nom' => 'Logement', 'description' => 'Loyer, hypothèque, et frais de services publics'],
            ['nom' => 'Transport', 'description' => 'Dépenses pour carburant, transports en commun, et entretien de véhicule'],
            ['nom' => 'Santé', 'description' => 'Dépenses médicales, pharmacie, et assurance santé'],
            ['nom' => 'Loisirs', 'description' => 'Activités de divertissement, abonnements, et sorties'],
            ['nom' => 'Éducation', 'description' => 'Frais de scolarité, livres, et formations'],
            ['nom' => 'Shopping', 'description' => 'Achats de vêtements, accessoires, et autres biens de consommation'],
            ['nom' => 'Voyages', 'description' => 'Dépenses pour les vacances et les voyages d\'affaires'],
            ['nom' => 'Cadeaux', 'description' => 'Achats de cadeaux pour les anniversaires, fêtes, et autres occasions spéciales'],
            ['nom' => 'Autres', 'description' => 'Dépenses diverses ne rentrant pas dans les autres catégories'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'nom' => $category['nom'],
                'description' => $category['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
