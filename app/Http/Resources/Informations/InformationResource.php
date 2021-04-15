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
        $json = [];

        $this->with = [
            'fields' => 'ok',
        ];;

        $json = parent::toArray($request);
        $json = array_merge($json, [
            'name' => $this->resource->name,
            'meta_title' => $this->resource->meta_title,
            'relateds' => $this->resource->related_list
        ]);
        

        return $json;
    }
}
