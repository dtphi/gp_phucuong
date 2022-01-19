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
            $groupImgs = $res->group_images;
            if (!empty($groupImgs)) {
                $sort = array_column($groupImgs, 'width');
                array_multisort($sort, SORT_ASC, $groupImgs);
            }
            $json = array_merge($json, [
                'group_albums_name'   => $res->name_group_albums,
                'group_images'        => $groupImgs,
                'image'               => $res->image_origin
            ]);
        }
        return $json;
        return parent::toArray($request);
    }
}
