<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationFullResource extends JsonResource
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
            'phones' => $this->phones->pluck('number'),
            'building' => new BuildingResource($this->building),
            'activities' => ActivityResource::collection($this->activities),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
