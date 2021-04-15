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

        $res = $this->resource;
        $json = parent::toArray($request);
        $json = array_merge($json, [
            'name' => $res->name,
            'description' => $res->description,
            'tag' => $res->tag,
            'meta_title' => $res->meta_title,
            'meta_description' => $res->meta_description,
            'meta_keyword' => $res->meta_keyword,
            'relateds' => $res->arr_related_list,
            'multi_images' => $res->arr_image_list,
            'categorys' => $res->arr_category_list,
            'downloads' => $res->arr_download_list
        ]);
        
        return $json;
    }
}
