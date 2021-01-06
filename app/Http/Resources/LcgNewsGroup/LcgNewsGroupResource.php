<?php

namespace App\Http\Resources\LcgNewsGroup;

use Illuminate\Http\Resources\Json\JsonResource;

class LcgNewsGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
