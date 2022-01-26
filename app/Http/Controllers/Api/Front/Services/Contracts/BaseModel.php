<?php

namespace App\Http\Controllers\Api\Front\Services\Contracts;

interface BaseModel
{
    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetList(array $options = [], $limit = 15);

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15);

    public function apiGetNewsGroupTrees();

    public function getMenuCategories($parentId = 0);

    public function apiGetCategoryById($categoryId = 0);

    public function apiGetMenuCategoryIds($parentId = 0);

    public function getMenuCategoriesToLayout($layoutId = 1);

    public function apiGetLatestInfos($limit = 5);

    public function apiGetPopularInfos($limit = 5);

    public function apiGetInfoListByIds($data = array());

    // public function apiGetListNgayLe($data = array(), $limit = 5);

    public function apiGetDetailNgayLe($id);

    public function apiGetGiaoXuList($data = array(), $limit = 5);

    public function apiGetDetailGiaoXu($id);

    public function apiGetLinhMucListByGiaoXuId($giaoXuId = null);

    public function apiGetLinhMucChanhXuByGiaoXuId($giaoXuId = null);

    public function apiGetLinhMucPhoXuByGiaoXuId($giaoXuId = null);

    public function apiGetLinhmucs($data = []);

    public function apiGetListLinhMuc(array $options = [], $limit = 15);

    public function apiGetDetailLinhMuc($id = null);
}
