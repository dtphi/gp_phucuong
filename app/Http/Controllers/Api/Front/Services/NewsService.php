<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\NewsModel;
use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\InformationToCategory;
use App\Models\InformationRelated;
use App\Http\Common\Tables;
use DB;

final class NewsService implements NewsModel
{
    /**
     * @author : dtphi .
     * NewsService constructor.
     */
    public function __construct()
    {
        $this->model    = new Information();
        $this->infoCate = new InformationToCategory();
        $this->infoRelated = new InformationRelated();
    }

    public function apiGetInfo($information_id) {
        // TODO: Implement apiGetDetail() method.
        $result = $this->model->findOrFail($information_id);
        if ($result) {
            return [
                'information_id' => $result->information_id,
                'name' => $result->name,
                'sort_description' => $result->sort_description,
                'description' => $result->description,
                'image' => $result->image,
                'viewed' => $result->viewed,
                'vote' => $result->vote
            ];
        } else {
            return false;
        }
	}

    public function apiGetLatestInfos($limit = 5) {
            $query = $this->model->select('information_id')
            ->orderByDesc('created_at')
            ->limit($limit);

        return $query->get();
	}

    public function apiGetPopularInfos($limit = 5) {
        $query = $this->model->select('information_id')
            ->orderByDesc('viewed')
            ->limit($limit);

        return $query->get();
	}

    public function apiGetCategories($infoId) {
        $query = $this->infoCate->select()
        ->where('information_id' , '=', $infoId);

        return $query->get();
	}

    public function apiGetInfoRelated($infoId) {
        $query = $this->infoRelated->select()
        ->leftJoin(Tables::$informations, Tables::$information_relateds . '.related_id' , '=', Tables::$informations . '.information_id')
        ->where(Tables::$information_relateds . '.information_id', '=', $infoId);
        

        return $query->get();
	}

    public function apiUpdateViewed($infoId) {
        $infoId = (int)$infoId;

        $affected = DB::update(
            'update ' . Tables::$informations . ' set viewed = (viewed + 1) where information_id = ?',
            [$infoId]
        );

        return $affected;
    }

    public function apiGetInfoList($data = array()) {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }

		$query = DB::table(Tables::$information_to_categorys)->select()
        ->leftJoin(Tables::$informations, Tables::$information_to_categorys.'.information_id', '=', Tables::$informations.'.information_id')
        ->leftJoin(Tables::$information_descriptions, Tables::$informations.'.information_id', '=', Tables::$information_descriptions.'.information_id')
        ->where('status', '=', '1')
        ->where('information_type', '=', $infoType);
           
        if (isset($data['category_id'])) {
          $query->where('category_id' , '=', $data['category_id']);
        }
        
        return $query->limit(20)->get();
	}

    public function apiGetInfoListByIds($data = array()) {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }

		$query = DB::table(Tables::$informations)->select()
        ->leftJoin(Tables::$information_descriptions, Tables::$informations.'.information_id', '=', Tables::$information_descriptions.'.information_id')
        ->where('status', '=', '1')
        ->where('information_type', '=', $infoType);
           
        if(isset($data['information_ids'])) {
            $query->whereIn(Tables::$informations . '.information_id', $data['information_ids']);
        }
        
        return $query->get();
	}
}
