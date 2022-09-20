<?php

namespace App\Http\Resources;

use App\Http\Resources\Category\CategoryCollectionResource;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'price' => (float)$this->price,
            'external_id' => $this->eid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories' => CategoryCollectionResource::collection($this->categories)
        ];
    }
}
