<?php

namespace App\Http\Resources\GiaoPhanHatXus;

use Illuminate\Http\Resources\Json\JsonResource;

class GiaoPhanHatXuResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'giaophan_hat_xu';

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
                'giaoXuOldId' => $res->id,
                'isEdit' => 1,
                'hatId' => $res->giao_phan_hat_id,
                'hatXuName' => $res->name
            ]);
        }

        return $json;
    }
}
