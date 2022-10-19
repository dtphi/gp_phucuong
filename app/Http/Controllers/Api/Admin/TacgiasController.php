<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Models\tacgias;
use App\Models\InformationDescription;
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
    public function getlisttacgias(Request $request)
    {   
        
        $active_tacgias=tacgias::where('deleted_at',null)->get();
        
        if ($request->id==null)
            return response()->json($active_tacgias);
        else {
            $infoID=$request->id;
            $selected_tacgia=InformationDescription::where('information_id',$infoID)->value('tac_gia');
            $name_selected_tacgia=tacgias::where('id',$selected_tacgia)->value('name');
            return response()->json([
                                    'active_tacgias'=>$active_tacgias,
                                    'selected_tacgia'=>$selected_tacgia,
                                    'name_tacgia'=>$name_selected_tacgia]);
        }
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
    public function editdatatacgias(Request $request)
    {
        $idtacgia = $request->idtacgia;
        $infoID= $request->infoID;
        if($idtacgia!=null && $infoID!=null){
            InformationDescription::where('information_id', $infoID)->update(['tac_gia' => $idtacgia]);
            return response()->json(true);
        }
        else return response()->json(false);
            
    }

}
