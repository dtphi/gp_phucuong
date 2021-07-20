<?php

namespace App\Http\Resources\GiaoPhanHats;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanHatResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan_hat';

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
                'giaoHatOldId' => $res->id,
                'isEdit' => 1,
                'cong_doan_tu_sis'=> $res->arr_cong_doan_tu_si_list,
                'giao_xus' => $res->arr_giao_xu_list,
                'hatName' => $res->name
            ]);
        }

        return $json;
    }
}
