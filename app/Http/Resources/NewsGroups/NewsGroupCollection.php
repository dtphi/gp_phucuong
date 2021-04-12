<?php

namespace App\Http\Resources\NewsGroups;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsGroupCollection extends ResourceCollection
{
    /**
     * @author : dtphi .
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {dd($this->collection->toArray());
        return [
            'results' => $this->collection,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
