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
            $_dir= request()->input('_dir');
            $rootDir = 'HoSo' . '/' . $res->id . '/' . 'AllFiles' . '/';
            if (!empty($_dir) && $_dir !== 'AllFiles') {
              $rootDir = 'HoSo' . '/' . $res->id . '/' . $_dir . '/';
            }

            $hoSoFiles = Storage::disk('public')->files($rootDir);
            $hoSoDirs = Storage::disk('public')->directories($rootDir);

            $hoSoList = [];
            foreach ($hoSoFiles as $hoSo) {
              $name = Str::replaceFirst($rootDir, '', $hoSo);
              $hoSoList[] = [
                'name' => $name,
                'type' => 'file',
                'url' => Storage::url($hoSo),
                '_dir' => url('admin/linh-mucs/edit/' . $res->id . '?_dir=' . $_dir . '/' . $name)
              ];
            }

            foreach ($hoSoDirs as $hoSo) {
              $name = Str::replaceFirst($rootDir, '', $hoSo);
              $hoSoList[] = [
                'name' => $name,
                'type' => 'dir',
                'url' => Storage::url($hoSo),
                '_dir' => url('admin/linh-mucs/edit/' . $res->id . '?_dir=' . $_dir . '/' . $name)
              ];
            }

            $arrDir = explode('/', $_dir);
            $breadbrum = [];
            $dirName = '';
            $lastDir = end($arrDir);
            unset($arrDir[count($arrDir) - 1]);
            foreach ($arrDir as $dir) {
              $queryDir = (empty($dirName)) ? $dir : $dirName . '/' . $dir;
              $breadbrum[] = '<li><a href="' . url('admin/linh-mucs/edit/1?_dir=' . $queryDir) . '">' . $dir . '</a></li>';
              $dirName = $dir;
            }
            $breadbrum[] = '<li><a href="javascript:void(0);">' . $lastDir . '</a></li>';

            $json = array_merge($json, [
              'breadbrum' => implode(' > ', $breadbrum),
              'ho_sos' => $hoSoList
            ]);
        }
        return $json;
    }
}
