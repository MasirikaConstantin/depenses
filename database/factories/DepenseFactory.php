<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Depense>
 */
class DepenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(300), // Texte d'introduction aléatoire
            'montant' => $this->faker->numberBetween(1000, 1000060), // Temps en minutes
            'categorie_id' => Categorie::inRandomOrder()->value('id') ?? Categorie::factory(), // ID valide ou création d'une nouvelle Catégorie
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(), // ID valide ou création d'un nouvel Utilisateur
            'date' => $this->faker->dateTimeBetween('-1 months', 'now'), // Dernière mise à jour
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Date de création
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'), // Dernière mise à jour
     
        ];
    }
}
