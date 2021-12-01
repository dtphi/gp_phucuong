<?php

namespace App\Http\Resources\Albums;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $json = [];

        $this->with = [
            'fields' => 'ok',
        ];

        $res  = $this->resource;
        if ($res) {
            $json = parent::toArray($request);
            $json = array_merge($json, [
                'group_albums_name'   => $res->name_group_albums,
                'group_images'        => $res->group_images
            ]);
        }

        return $json;
        return parent::toArray($request);
    }
}
