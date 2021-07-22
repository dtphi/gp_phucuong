<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface InformationModel
{
    public function apiInsert($data = []);

    public function getInfoDesById($infoId = null);

    public function apiUpdate($model, $data = []);

    public function apiGetBuilderInformations($data = [], $limit = 5);

    public function apiGetInformations($data = array(), $limit = 5);

    public function deleteInformation($model = null);
}
