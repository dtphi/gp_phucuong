<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Models\tacgias;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Log;
use stdClass;

class TacgiasController extends ApiController
{   

    public $tacgias=null;
    public function __construct(){
       $this->tacgias=tacgias::all();
    }
    public function getlisttacgias()
    {
        $active_tacgias=tacgias::where('deleted_at',null)->get();
        // $tacgias=$this->tacgias;
        
        return response()->json($active_tacgias);
    }
    public function addtacgias(Request $request)
    {
        $name = $request->name;
        $isExistName=tacgias::where('name',$name)->exists();
        if(!$isExistName){
            $newname = new tacgias();
            $newname->name= $name;
            $newname->save();
            return response()->json(true);
        } else return response()->json(false);


    }
    public function deltacgias(Request $request)
    {
        $id = $request->id;
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        //dd($current_date_time);
        if($id!=null){
            tacgias::where('id', $id)->update(['deleted_at' => $current_date_time]);
            return response()->json(true);
        }
        else return response()->json(false);
    }
    public function edittacgias(Request $request)
    {
        $id = $request->id;
        $name= $request->name;
        if($id!=null && $name!=null){
            tacgias::where('id', $id)->update(['name' => $name]);
            return response()->json(true);
        }
        else return response()->json(false);
            
    }

}
