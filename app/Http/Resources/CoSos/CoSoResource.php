<?php

namespace App\Http\Resources\CoSos;

use Illuminate\Http\Resources\Json\JsonResource;

class CoSoResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'dong';

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
