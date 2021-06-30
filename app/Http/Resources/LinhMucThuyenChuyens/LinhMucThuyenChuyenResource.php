<?php

namespace App\Http\Resources\LinhMucThuyenChuyens;

use Illuminate\Http\Resources\Json\JsonResource;

class LinhMucThuyenChuyenResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'linhmuc_thuyenchuyen';

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
                'isEdit' => 1,
                'fromgiaoxuName'      => $res->ten_from_giao_xu,
                'fromchucvuName' => $res->ten_from_chuc_vu,
                'label_from_date' => ($res->from_date)?date_format(date_create($res->from_date),"d-m-Y"):'',
                'ducchaName' => $res->ten_duc_cha,
                'label_to_date' => ($res->to_date)?date_format(date_create($res->to_date),"d-m-Y"):'',
                'chucvuName' => $res->ten_to_chuc_vu,
                'giaoxuName' => $res->ten_to_giao_xu,
                'cosogpName' => $res->ten_co_so,
                'dongName' => $res->ten_dong,
                'banchuyentrachName' => $res->ten_ban_chuyen_trach,
            ]);
        }

        return $json;
    }
}
