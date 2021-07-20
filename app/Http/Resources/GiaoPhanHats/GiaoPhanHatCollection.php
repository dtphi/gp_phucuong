<?php

namespace App\Http\Resources\GiaoPhanHats;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GiaoPhanHatCollection extends ResourceCollection
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
        foreach ($this->collection as $hat) {
            $results[] = $hat;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
