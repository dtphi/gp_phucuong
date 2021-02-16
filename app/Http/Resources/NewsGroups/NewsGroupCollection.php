<?php

namespace App\Http\Resources\NewsGroups;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsGroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'results' => $this->collection,
            'errors' => [],
            'status' => 1000
        ];
    }
}
