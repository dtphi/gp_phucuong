<?php

namespace App\Http\Resources\LinhMucs;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinhMucCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
