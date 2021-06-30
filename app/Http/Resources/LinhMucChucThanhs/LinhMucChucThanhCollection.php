<?php

namespace App\Http\Resources\LinhMucChucThanhs;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinhMucChucThanhCollection extends ResourceCollection
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
        foreach ($this->collection as $chucThanh) {
            $results[] = $chucThanh;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
