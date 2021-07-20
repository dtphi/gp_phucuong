<?php

namespace App\Http\Resources\GiaoPhanBanChuyenTrachs;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanBanChuyenTrachResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan_ban_chuyen_trach';

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
                'banChuyenTrachOldId' => $res->id,
                'isEdit' => 1,
                'banChuyenTrachName' => $res->name
            ]);
        }

        return $json;
    }
}
