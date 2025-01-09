<?php

namespace Database\Seeders;

use App\Models\Depense;
use App\Models\Entre;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       //User::factory(10)->create();
       Depense::factory(100)->create();
       Entre::factory(300)->create();

       /*$this->call([
        ClearEntresAndDepensesSeeder::class,
    ]);*/
    }
}
