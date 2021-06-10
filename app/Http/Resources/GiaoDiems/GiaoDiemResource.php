<?php

namespace App\Http\Resources\GiaoDiems;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoDiemResource extends JsonResource
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
