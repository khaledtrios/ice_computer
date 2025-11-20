<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PanneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom ?? '',
            'type' => $this->type ?? '',
            'description' => $this->description ?? '',
            'prix_initial' => $this->prix_initial ?? 0,
            'prix_promo' => $this->prix_promo ?? 0,
            'image' => $this->image,
            'priorite'=>$this->priorite ?? 0 ,
            'remise' => $this->remise ?? 0,
            'afficher' => true,
            'couleurs' => $this->couleurs ?? [],
        ];
    }

}
