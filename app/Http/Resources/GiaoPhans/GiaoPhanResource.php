<?php

namespace App\Http\Resources\GiaoPhans;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan';

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
                'giao_phan_hats'            => $res->arr_hat_list,
                'giao_phan_dongs'           => $res->arr_dong_list,
                'giao_phan_cosos'           => $res->arr_coso_list,
                'giao_phan_banchuyentrachs' => $res->arr_ban_chuyen_trach_list,
                'giao_phan_hat_xu_diems'    => []
                //'sort_description'      => html_entity_decode($res->sort_description),
            ]);
        }

        return $json;
    }
}
