<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Models\tacgias;
use App\Models\InformationDescription;
use App\Models\Informations;
use App\Models\InformationCarousel;
use App\Models\InformationRelated;
use App\Models\InformationToCategory;
use App\Http\Controllers\Api\Front\Services\Contracts\NewsModel as NewsSv;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use stdClass;

class TacgiasController extends ApiController
{   
        /**
     * @var NewsSv|null
     */
    private $newsSv = null;

    /**
     * @author : dtphi .
     * NewsController constructor.
     * @param NewsSv $newsSv
     * @param array $middleware
     */
    public function __construct(NewsSv $newsSv)
    {
        $this->newsSv = $newsSv;
    }

    /**
     * [getServiceContext:  ]
     * @return [type] [description]
     */
    public function getServiceContext()
    {
        return $this->newsSv;
    }

    public $tacgias=null;
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
    public function getInfoTacgia(Request $request){
        $widthThumbInfoList  = 184;
        $heightThumbInfoList = 120;
        $tacgiaID=$request->tacgia;
        $infoDES=InformationDescription::where('tac_gia',$tacgiaID)->get();
        $infoIDs=[];
        foreach ($infoDES as $info){
           array_push($infoIDs,$info->information_id);
        }
        $params['information_ids'] = $infoIDs;
        $results = $this->newsSv->apiGetInfoListByIds($params);
        $json = [];
        foreach ($results as $info) {
            $staticImg     = self::$thumImgNo;
            $staticThumImg = self::$thumImgNo;

            if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                $staticImg = $info->image;
            }

            $staticThumImg      = (!empty($info->image)) ? $this->getThumbnail($info->image,
                $widthThumbInfoList, $heightThumbInfoList) : $this->getThumbnail($staticImg,
                $widthThumbInfoList, $heightThumbInfoList);
            $imgCarouselThumUrl = (!empty($info->image)) ? $this->getThumbnail($info->image, 750,
                550) : $this->getThumbnail($staticImg, 750, 550);

            $sortDes = html_entity_decode($info->sort_description);
           
            $json[] = [
                'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                'description'      => html_entity_decode($info->sort_description),
                'sort_description' => Str::substr($sortDes, 0, 100),
                'image'            => $staticImg,
                'imgUrl'           => url($staticImg),
                'imgThumUrl'       => url($staticThumImg),
                'imgCarThumUrl'    => url($imgCarouselThumUrl),
                'information_id'   => $info->information_id,
                'name'             => $info->name,
                'name_slug'        => $info->name_slug,
                'sort_name'        => Str::substr($info->name, 0, 28),
                'viewed'           => $info->viewed,
                'vote'             => $info->vote
            ];
        }
        return response()->json($json);
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
