<?php

namespace App\Http\Controllers\Api\Front\Services\Contracts;

interface SettingModel
{
    public function apiGetList(array $options = [], $limit = 15);

    public function apiGetCategoryByIds($ids = []);

    public function apiGetDetail($id = null);

    public function apiGetSettingByCodes($code = '');
}
