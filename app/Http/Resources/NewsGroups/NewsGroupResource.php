<?php

namespace App\Http\Resources\NewsGroups;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsGroupResource extends JsonResource
{
    public static $wrap = 'newsgroup';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
