<?php

namespace App\Http\Resources\LcgNewsGroup;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LcgNewsGroupCollection extends ResourceCollection
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
