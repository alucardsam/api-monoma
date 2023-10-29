<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MetaFalseResource extends JsonResource
{
  public static $wrap = '';
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'meta' => [
        'success' => false,
        'errors' => [
          $this->errors
        ]
      ]
    ];
  }
}
