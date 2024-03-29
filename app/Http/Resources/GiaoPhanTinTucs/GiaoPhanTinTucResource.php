<?php

namespace App\Http\Resources\GiaoPhanTinTucs;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanTinTucResource extends JsonResource
{
  public static $wrap = 'giaophantintucs';
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
    ];

    $res  = $this->resource;
    if ($res) {
      $json = parent::toArray($request);
      $json = array_merge($json, [
        'name'                  => $res->name,
        'date_available'        => date_format(date_create($res->date_available), "Y-m-d H:i:s"),
        'sort_description'      => html_entity_decode($res->sort_description),
        'description'           => $res->description,
        'tag'                   => $res->tag,
        'meta_title'            => $res->meta_title,
        'meta_description'      => $res->meta_description,
        'meta_keyword'          => $res->meta_keyword,
        'relateds'              => $res->arr_related_list,
        'multi_images'          => $res->arr_image_list,
        'categorys'             => $res->arr_category_list,
        'downloads'             => $res->arr_download_list,
        'category_display_list' => $res->category_display_list,
        'special_carousels'     => $res->special_carousels
      ]);
    }

    return $json;
  }
}
