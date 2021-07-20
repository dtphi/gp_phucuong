<?php

namespace App\Http\Resources\LinhMucBangCaps;

use Illuminate\Http\Resources\Json\JsonResource;

class LinhMucBangCapResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'linhmuc_bangcap';

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
