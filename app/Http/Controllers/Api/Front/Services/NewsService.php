<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Front\Services\Contracts\NewsModel;
use App\Models\Information;
use App\Models\InformationRelated;
use App\Models\InformationToCategory;
use DB;
use Illuminate\Http\Request;

final class NewsService extends Service implements NewsModel
{
    /**
     * @author : dtphi .
     * NewsService constructor.
     */
    public function __construct()
    {
        $this->model       = new Information();
        $this->infoCate    = new InformationToCategory();
        $this->infoRelated = new InformationRelated();
    }

    public function apiGetInfo($information_id, $param_slug = null)
    {
        // TODO: Implement apiGetDetail() method.
        $result = $this->model->findOrFail($information_id);
        if ($result) {
            return [
                'information_id'   => $result->information_id,
                'name'             => $result->name,
                'date_available'   => date_format(date_create($result->date_available), "d-m-Y"),
                'sort_description' => html_entity_decode($result->sort_description),
                'description'      => $result->description,
                'image'            => $result->image,
                'viewed'           => $result->viewed,
                'vote'             => $result->vote,
                'tag'              => (!empty($result->tag)) ? explode(',', $result->tag) : [],
                'albums'           => $result->arr_album_list,
                'related_category' => !empty($result->arr_category_list) ? $result->arr_category_list[0] : null,
                'link_chi_tiet' => '/tin-tuc/chi-tiet/' . $param_slug
            ];
        } else {
            return false;
        }
    }

    public function apiGetLatestInfos($limit = 5)
    {
        $query = $this->model->select('information_id')
            ->orderByDescDateAvailable()
            ->limit($limit);

        return $query->get();
    }

    public function apiGetPopularInfos($limit = 5)
    {
        $query = $this->model->select('information_id')
            ->orderByDescViewed()
            ->limit($limit);

        return $query->get();
    }

    public function apiGetCategories($infoId)
    {
        $query = $this->infoCate->select()
            ->filterByInfoId($infoId);

        return $query->get();
    }

    public function apiGetInfoRelated($infoId)
    {
        $query = $this->infoRelated->select()
            ->lfJoinInfo()
            ->filterByInfoId($infoId);


        return $query->get();
    }

    public function apiUpdateViewed($infoId)
    {
        $infoId = (int)$infoId;

        $affected = DB::update(
            'update ' . Tables::$informations . ' set viewed = (viewed + 1) where information_id = ?',
            [$infoId]
        );

        return $affected;
    }

    public function apiGetInfoList($data = array())
    {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }
        if (!empty($data['news_group_type'])) {
            return $this->_apiGetTagInfoList($data);
        }

        $query = DB::table(Tables::$information_to_categorys)->select([
            'category_id',
            'date_available',
            'sort_description',
            'image',
            Tables::$informations . '.information_id',
            'information_type',
            'name',
            'name_slug',
            'viewed',
            'vote'
        ])
            ->leftJoin(Tables::$informations, Tables::$information_to_categorys . '.information_id', '=',
                Tables::$informations . '.information_id')
            ->leftJoin(Tables::$information_descriptions, Tables::$informations . '.information_id', '=',
                Tables::$information_descriptions . '.information_id')
            ->where('status', '=', '1');

        if (isset($data['all_category_children']) && !empty($data['all_category_children'])) {
            $query->whereIn('category_id', $data['all_category_children']);
        } else {
            if (isset($data['category_id']) && $data['category_id']) {
                $query->where('category_id', '=', $data['category_id']);
            } else {
                $query->where('information_type', '=', $infoType);
            }
        }

        $limit = 20;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->paginate($limit);
    }

    public function _apiGetTagInfoList($data = array())
    {
        $query = DB::table(Tables::$informations)->select([
            'category_id',
            'date_available',
            'sort_description',
            'image',
            Tables::$informations . '.information_id',
            'information_type',
            'name',
            'name_slug',
            'viewed',
            'vote'
        ])
          ->leftJoin(Tables::$information_to_categorys, Tables::$informations . '.information_id', '=',Tables::$informations . '.information_id')
            ->leftJoin(Tables::$information_descriptions, Tables::$informations . '.information_id', '=',
                Tables::$information_descriptions . '.information_id')
            ->where(Tables::$informations . '.status', '=', '1')
            ->where(Tables::$information_descriptions . '.tag', 'LIKE', '%'.$data['tag'].'%');

        $limit = 20;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');
        $query->groupBy('information_id');

        return $query->paginate($limit);
    }

    public function apiGetInfoListByIds($data = array())
    {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }

        $query = DB::table(Tables::$informations)->select(
            [
                'date_available',
                'sort_description',
                'image',
                Tables::$informations . '.information_id',
                'information_type',
                'name',
                'name_slug',
                'viewed',
                'vote'
            ]
        )
            ->leftJoin(Tables::$information_descriptions, Tables::$informations . '.information_id', '=',
                Tables::$information_descriptions . '.information_id')
            ->where('status', '=', '1')
            ->where('information_type', '=', $infoType);

        if (isset($data['information_ids'])) {
            $query->whereIn(Tables::$informations . '.information_id', $data['information_ids']);
        }

        $limit = 20;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->get();
    }

    public function apiGetInfoCarouselListByIds($data = array())
    {

        $query = DB::table(Tables::$information_carousel)->select(
            [
                'date_available',
                'sort_description',
                'image',
                'image_origin',
                'information_id',
                'information_type',
                'name',
                'name_slug',
                'viewed',
                'vote'
            ]
        );

        if (isset($data['information_ids'])) {
            $query->whereIn(Tables::$information_carousel . '.information_id', $data['information_ids']);
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->get();
    }
}
