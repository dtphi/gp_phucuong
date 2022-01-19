<?php

namespace App\Http\Controllers\Api\Front\Services\Contracts;

interface NewsModel
{
    public function apiGetInfo($information_id);

    public function apiGetLatestInfos($limit = 5);

    public function apiGetPopularInfos($limit = 5);

    public function apiGetCategories($infoId);

    public function apiGetInfoRelated($infoId);

    public function apiUpdateViewed($infoId);

    public function apiGetInfoList($data = array());

    public function apiGetInfoListByIds($data = array());

    public function apiGetInfoCarouselListByIds($data = array());
}
