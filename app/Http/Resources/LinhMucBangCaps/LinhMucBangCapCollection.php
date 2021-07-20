<?php

namespace App\Http\Resources\LinhMucBangCaps;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinhMucBangCapCollection extends ResourceCollection
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
        foreach ($this->collection as $bangCap) {
            $results[] = $bangCap;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
