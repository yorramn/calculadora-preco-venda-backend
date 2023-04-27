<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Plan\PlanResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'social_name' => $this->social_name,
            'plans' => PlanResource::collection($this->plan)
        ];
    }
}
