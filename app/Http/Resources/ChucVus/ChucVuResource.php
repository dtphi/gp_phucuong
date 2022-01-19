<?php

namespace App\Http\Resources\ChucVus;

use Illuminate\Http\Resources\Json\JsonResource;

class ChucVuResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'chuc_vu';

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
            $json = array_merge($json, []);
        }

        return $json;
    }
}
