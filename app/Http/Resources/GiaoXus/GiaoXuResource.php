<?php

namespace App\Http\Resources\GiaoXus;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoXuResource extends JsonResource
{
	  public static $wrap = 'giaoxu';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $json = [];

        $res = $this->resource;
        if ($res) {
            $json = parent::toArray($request);
            $json = array_merge($json, [
                'thuyen_chuyens' => $res->arr_thuyen_chuyen_list,
            ]);
        }
        return $json;
    }
}
