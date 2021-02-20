<?php

namespace App\Http\Resources\Informations;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
{
    public static $wrap = 'information';
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
