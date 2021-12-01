<?php

namespace App\Http\Resources\Albums;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlbumsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'results' => $this->collection,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
