<?php

namespace App\Http\Resources\LinhMucs;

use Illuminate\Http\Resources\Json\JsonResource;

class LinhmucResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'linhmuc';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $json = [];

        $res = $this->resource;
        if ($res) {
            $json = parent::toArray($request);
            $json = array_merge($json, [
                'image'                      => trim($res->image, '/'),
                'password'                   => '',
                'lable_ngay_thang_nam_sinh'  => ($res->ngay_thang_nam_sinh)?date_format(date_create($res->ngay_thang_nam_sinh), "d-m-Y"):'',
                'lable_ngay_rua_toi'         => ($res->ngay_rua_toi)?date_format(date_create($res->ngay_rua_toi), "d-m-Y"):'',
                'lable_ngay_them_suc'        => ($res->ngay_them_suc)?date_format(date_create($res->ngay_them_suc), "d-m-Y"):'',
                'lable_ngay_tieu_chung_vien' => ($res->ngay_tieu_chung_vien)?date_format(date_create($res->ngay_tieu_chung_vien), "d-m-Y"):'',
                'lable_ngay_dai_chung_vien'  => ($res->ngay_dai_chung_vien)?date_format(date_create($res->ngay_dai_chung_vien), "d-m-Y"):'',
                'lable_ngay_cap_cmnd'        => ($res->ngay_cap_cmnd)?date_format(date_create($res->ngay_cap_cmnd), "d-m-Y"):'',
                'lable_ngay_trieu_dong'      => ($res->ngay_trieu_dong)?date_format(date_create($res->ngay_trieu_dong), "d-m-Y"):'',
                'lable_ngay_khan'            => ($res->ngay_khan)?date_format(date_create($res->ngay_khan), "d-m-Y"):'',
                'lable_ngay_rip'             => ($res->ngay_rip)?date_format(date_create($res->ngay_rip), "d-m-Y"):'',
                'ten_thanh_name'             => $res->ten_thanh,
                'giao_xu_name'               => $res->ten_giao_xu,
                'ten_dong_name'              => $res->ten_dong,
                'rip_giaoxu_name'            => $res->ten_rip_giao_xu,
                'bang_caps'                  => $res->arr_bang_cap_list,
                'chuc_thanhs'                => $res->arr_chuc_thanh_list,
                'thuyen_chuyens'             => $res->arr_thuyen_chuyen_list,
                'van_thus'                   => $res->arr_van_thu_list,
                'bo_nhiems'                  => $res->arr_bo_nhiem_list
            ]);
        }

        return $json;
    }
}
