<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClothingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'type' => $this->type,
            'size' => $this->size,
            'colour' => $this->colour,
            'price' => $this->price,
            'gender' => $this->gender,
        ];
    }
}
