<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DepenseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'description' => $this->description,
            'date' => Carbon::parse($this->date)->format('Y-m-d'), // Conversion de la date
            'categorie' => [
                'id' => $this->categorie->id,
                'nom' => $this->categorie->nom
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            // Ajoutez d'autres champs selon vos besoins
        ];
    }
}