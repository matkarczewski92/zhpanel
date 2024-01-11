<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
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
            'code' => $this->public_profile_tag,
            'name' => $this->name,
            'sex' => $this->sex,
            'litterId' => $this->litter_id,
            'offer' => ['offer' => $this->animalOffer, 'reservation' => $this->animalOffer->offerReservation],
        ];
    }
}
