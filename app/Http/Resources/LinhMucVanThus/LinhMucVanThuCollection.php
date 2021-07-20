<?php

namespace App\Http\Resources\LinhMucVanThus;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinhMucVanThuCollection extends ResourceCollection
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
        foreach ($this->collection as $vanThu) {
            $results[] = $vanThu;
        }

        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
