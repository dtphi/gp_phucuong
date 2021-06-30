<?php

namespace App\Http\Resources\LinhMucThuyenChuyens;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinhMucThuyenChuyenCollection extends ResourceCollection
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
        foreach ($this->collection as $thuyenChuyen) {
            $results[] = $thuyenChuyen;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
