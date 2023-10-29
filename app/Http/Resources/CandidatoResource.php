<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidatoResource extends JsonResource
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
      'id' => $this->resource->id,
      'name' => $this->resource->name,
      'source' => $this->resource->source,
      'owner' => $this->resource->owner,
      'created_at' => date($this->resource->created_at),
      'created_by' => $this->resource->created_by
    ];
  }
}
