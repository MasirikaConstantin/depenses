<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
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
        }
    }
}
