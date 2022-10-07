<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\DongModel as DongSv;
use App\Http\Requests\DongRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Log;
use stdClass;

class ExplorerController extends ApiController
{   
    public $storage = "";
    public $pathStorage = "";
    public $fileallow = ["jpg", "png", "zip","pdf","xlsx"];
    public function __construct(){
        $this->storage = Storage::disk('public');
        $this->pathStorage = $this->storage->getAdapter()->getPathPrefix();
        
    }

    public function getlistdir(Request $request)
    {
        
        $skipFile = ['.', '..', '.htaccess'];
        $id = $request->id;
        $storagePublic = Storage::disk('public');
        $rootDir = 'HoSo' . '/' . $id . '/' . 'AllFiles' . '/';
        
//dd( $rootDir );
        $dirRead1 = $this->pathStorage . "\\HoSo\\$id";
        

        if (!file_exists($dirRead1)) {
            mkdir($dirRead1, 0777, true);
        }
        $dirRead = $dirRead1 . "\\AllFiles\\";
        if (!file_exists($dirRead)) {
            mkdir($dirRead, 0777, true);
        }

        if (!empty($request->dir) && $request->dir !== 'AllFiles') {
            $dirRead .= "\\$request->dir";
        }

        $hoSoFiles = $storagePublic->files($dirRead);
        $hoSoDirs = $storagePublic->directories($dirRead);


        //dd([$hoSoFiles,$hoSoDirs]); 
        $mode = 0;
        $files = scandir($dirRead, 1);
        $lst = [];
        foreach ($files as $file) {
            if (in_array($file, $skipFile)) {
                continue;
            }
            if (($mode == 0 || $mode == 1) && is_file("$dirRead\\$file")) {
                $fl = new stdClass();
                $path = "$dirRead\\$file";
                $fl->name = $file;
                $fl->path = $path;
                $fl->pathreal="/storage/HoSo/".$id."/AllFiles/".$request->dir."/$file";
                $fl->size = filesize($path);
                $fl->date = filemtime($path);
                $fl->type = filetype($path);
                $lst[] = $fl;
            }
            if (($mode == 0 || $mode == 2) && is_dir("$dirRead\\$file")) {
                $fl = new stdClass();
                $path = "$dirRead\\$file";
                $fl->name = $file;
                $fl->path = $path;
                $fl->type = 'folder';
                $lst[] = $fl;
            }
        }
        return response()->json($lst);
    }

    public function delFile(Request $request)
    {
        $id=$request->id;
        
        $folderName=$request->name;
      
        $folderContain=$this->pathStorage.'/HoSo' . '/' . $id . '/' . 'AllFiles' . '/';
        $dir=$folderContain.$folderName;
        
        if (file_exists($dir)) {
            if (is_file($dir)) unlink($dir);
            else if (is_dir($dir)) $this->rrmdir($dir);
            return response()->json(true);
        }
        return response()->json(false);
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir . '\\' . $object) == 'dir') {
                        rrmdir($dir . '\\' . $object);
                    } else {
                        unlink($dir . '\\' . $object);
                    }
                }
            }

            reset($objects);
            rmdir($dir);
        }
    }

    public function upload(Request $request){
        $id=$request->id;
        $folderUpload=$this->pathStorage.'/HoSo' . '/' . $id . '/' . 'AllFiles' . '/';
        $files =  $request->file('fileToUpload');
        $filenameup = $files->getClientOriginalName();
        $targetdir=$request->targetdir;
        
        $ext = pathinfo($filenameup, PATHINFO_EXTENSION);
        $filesave = $filenameup;
        // $filesave = str_replace("@GUI", guid(), $filesave);
        // $filesave = str_replace("@EXT", $ext, $filesave);
        $res = null;
        
        if (in_array($ext, $this->fileallow)) {
            $target_file = "$folderUpload/$filesave";
            if ($files->move($folderUpload.$targetdir,$files->getClientOriginalName())) {
                $res = new stdClass();
                $res->nameOld = $files->getClientOriginalName();
                //$res->size = $files->getSize();
                $res->name = $filesave;
                $res->target = $target_file;
                //$res->path = "$urlUpload/$target_file";
            }
        }
        return response()->json($res);


        
    }
    public function newFolder(Request $request){
        $id=$request->id;
        $folderUpload=$this->pathStorage.'/HoSo' . '/' . $id . '/' . 'AllFiles' . '/';
        $dir=$request->name;
        $folderNameDir=$folderUpload . $dir;
        if(!file_exists($folderNameDir)){
            mkdir($folderNameDir, 0777, true);
            return response()->json(true);
        }
        else return response()->json(false);;
    }
    


}
