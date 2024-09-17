<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'name' => $this->name,
            'fullName' => $this->fullName,
            'article' => $this->article,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'description' => $this->description,
            'images' => $this->images,
            'category' => ProductResource::collection($this->getCategory())
        ];
    }
}
