<?php

namespace App\Http\Resources\LinhMucs;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
use Str;

class LinhmucHoSoResource extends JsonResource
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
            $rootDir = 'HoSo' . '/' . $res->id . '/' . 'AllFiles' . '/';
            $hoSoFiles = Storage::disk('public')->files($rootDir);
            $hoSoDirs = Storage::disk('public')->directories($rootDir);
            $hoSoList = [];
            foreach ($hoSoFiles as $hoSo) {
              $hoSoList[] = [
                'name' => Str::replaceFirst($rootDir, '', $hoSo),
                'type' => 'file',
                'url' => Storage::url($hoSo)
              ];
            }
            foreach ($hoSoDirs as $hoSo) {
              $hoSoList[] = [
                'name' => Str::replaceFirst($rootDir, '', $hoSo),
                'type' => 'dir',
                'url' => Storage::url($hoSo)
              ];
            }
            $json = array_merge($json, [
              'ho_sos' => $hoSoList
            ]);
        }
        return $json;
    }
}
