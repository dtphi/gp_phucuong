<?php

namespace App\Http\Resources\GiaoPhanHatCongDoanTuSis;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanHatCongDoanTuSiResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan_hat_cong_doan_tu_si';

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
                'congDoanTuSiOldId' => $res->id,
                'isEdit' => 1,
                'hatId' => $res->giao_phan_hat_id,
                'hatCongDtsName' => $res->name
            ]);
        }

        return $json;
    }
}
