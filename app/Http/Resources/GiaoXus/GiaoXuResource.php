<?php

namespace App\Http\Resources\GiaoXus;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoXuResource extends JsonResource
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
