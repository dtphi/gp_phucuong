<?php

namespace App\Http\Resources\GiaoPhanDongs;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanDongResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan_dong';

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
                'dongOldId' => $res->id,
                'isEdit' => 1,
                'dongName' => $res->name
            ]);
        }

        return $json;
    }
}
