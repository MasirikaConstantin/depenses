<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepenseJournalie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Dans DepenseResource.php

    return [
        "id" => $this->id,
        "user_id" => $this->user_id,
        "categorie_id" => $this->categorie_id,
        "montant" => $this->montant,
        "description" => $this->description,
        "date" => $this->date,
        "created_at" => $this->created_at,
        "updated_at" => $this->updated_at,
        "user" => UserResource::collection($this->whenLoaded('users')),
        "categorie" => CategorieResource::collection($this->whenLoaded('categories')),
        "totalJournalier" => $this->when(isset($this->totalJournalier), $this->totalJournalier)
    ];
    }
}
