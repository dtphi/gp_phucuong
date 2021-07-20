<?php

namespace App\Http\Resources\GiaoPhanCoSos;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanCoSoResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan_co_so';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $json = [];

        $this->with = [
            'fields' => 'ok',
        ];

        $res = $this->resource;
        if ($res) {
            $json = parent::toArray($request);
            $json = array_merge($json, [
                'coSoOldId' => $res->id,
                'isEdit' => 1,
                'cosoName' => $res->name
            ]);
        }

        return $json;
    }
}
