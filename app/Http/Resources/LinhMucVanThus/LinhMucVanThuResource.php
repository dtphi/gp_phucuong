<?php

namespace App\Http\Resources\LinhMucVanThus;

use Illuminate\Http\Resources\Json\JsonResource;

class LinhMucVanThuResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'linhmuc_vanthu';

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
                'isEdit' => 1
            ]);
        }

        return $json;
    }
}
