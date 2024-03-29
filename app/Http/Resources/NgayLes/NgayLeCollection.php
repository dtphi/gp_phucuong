<?php

namespace App\Http\Resources\NgayLes;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NgayLeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $results = [];
        foreach ($this->collection as $xu) {
            $results[] = $xu;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}