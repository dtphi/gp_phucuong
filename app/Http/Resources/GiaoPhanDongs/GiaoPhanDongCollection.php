<?php

namespace App\Http\Resources\GiaoPhanDongs;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GiaoPhanDongCollection extends ResourceCollection
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
        foreach ($this->collection as $dong) {
            $results[] = $dong;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
