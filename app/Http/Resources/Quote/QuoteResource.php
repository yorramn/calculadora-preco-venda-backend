<?php

namespace App\Http\Resources\Quote;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
            'name' => $this->name,
            'total_fixed_costs' => $this->total_fixed_costs,
            'total_variable_costs' => $this->total_variable_costs,
            'price_sale' => $this->price_sale,
            'link' => $this->link,
            'status' => $this->status,
            'category' => new CategoryResource($this->category),
            'owner' => $this->owner,
            'product' => $this->product,
            'created_at' => $this->created_at
        ];
    }
}
