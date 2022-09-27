<?php

namespace App\Http\Resources\LinhMucs;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
use Str;
use Illuminate\Support\Carbon;

class LinhmucHoSoResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'linhmuc';

    public function convert($size,$unit)
    {
     if($unit == "KB")
     {
      return $fileSize = round($size / 1024,4) . 'KB';
     }
     if($unit == "MB")
     {
      return $fileSize = round($size / 1024 / 1024,4) . 'MB';
     }
     if($unit == "GB")
     {
      return $fileSize = round($size / 1024 / 1024 / 1024,4) . 'GB';
     }
    }

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

            $storagePublic = Storage::disk('public');

            $hoSoFiles = $storagePublic->files($rootDir);
            $hoSoDirs = $storagePublic->directories($rootDir);

            $hoSoList = [];
            foreach ($hoSoFiles as $hoSo) {
              $name = Str::replaceFirst($rootDir, '', $hoSo);
              $hoSoList[] = [
                'name' => $name,
                'type' => 'file',
                'size' => $this->convert($storagePublic->size($hoSo), 'KB'),
                'lastModified' => Carbon::createFromTimestamp($storagePublic->lastModified($hoSo))->format('d/m/Y'),
                'url' => Storage::url($hoSo),
                '_dir' => url('admin/linh-mucs/edit/' . $res->id . '?_dir=' . $_dir . '/' . $name)
              ];
            }

            foreach ($hoSoDirs as $hoSo) {
              $name = Str::replaceFirst($rootDir, '', $hoSo);
              $hoSoList[] = [
                'name' => $name,
                'type' => 'dir',
                'size' => count($storagePublic->files($hoSo)) . ' Files',
                'lastModified' => Carbon::createFromTimestamp($storagePublic->lastModified($hoSo))->format('d/m/Y'),
                'url' => Storage::url($hoSo),
                '_dir' => url('admin/linh-mucs/edit/' . $res->id . '?_dir=' . $_dir . '/' . $name)
              ];
            }

            $arrDir = explode('/', $_dir);
            $breadbrum = [];
            $dirName = '';
            $lastDir = end($arrDir);
            if ($lastDir == 'AllFiles') {
              $lastDir = 'All Files';
            }

            unset($arrDir[count($arrDir) - 1]);
            foreach ($arrDir as $key => $dir) {
              $queryDir = (empty($dirName)) ? $dir : $dirName . '/' . $dir;
              if ($key == 0) {
                $breadbrum[] = '<li><a href="' . url('admin/linh-mucs/edit/' . $res->id  . '?_dir=' . $queryDir) . '">All Files</a></li>';
              } else {
                $breadbrum[] = '<li><a href="' . url('admin/linh-mucs/edit/' . $res->id  . '?_dir=' . $queryDir) . '">' . $dir . '</a></li>';
              }

              $dirName = $dir ;
            }

            $breadbrum[] = '<li><a href="javascript:void(0);">' . $lastDir . '</a></li>';

            $json = array_merge($json, [
              'breadbrum' => implode('  ', $breadbrum),
              'ho_sos' => $hoSoList
            ]);
        }
        return $json;
    }
}
