<?php

namespace App\Http\Resources\LinhMucChucThanhs;

use Illuminate\Http\Resources\Json\JsonResource;

class LinhMucChucThanhResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'linhmuc_chucthanh';

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
                'label_ngay_thang_nam_chuc_thanh' => ($res->ngay_thang_nam_chuc_thanh)?date_format(date_create($res->ngay_thang_nam_chuc_thanh),"d-m-Y"):''
            ]);
        }

        return $json;
    }
}
