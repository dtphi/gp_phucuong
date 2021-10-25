<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface GiaoPhanDanhMucModel
{
    public function apiGetGiaoPhanDanhMucTrees($data = array());

    public function apiInsert(array $data = []);

    public function getCateogryById($categoryId = null);

    public function getCategoryDesById($categoryId = null);

    public function apiUpdate($model, array $data = []);

    public function deleteCategory($model);

    public function apiGetCategories($data = array(), $limit = 15);
}
