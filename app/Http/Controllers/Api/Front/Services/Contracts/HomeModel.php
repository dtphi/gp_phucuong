<?php

namespace App\Http\Controllers\Api\Front\Services\Contracts;

interface HomeModel
{
    public function getMenuCategories($parentId = 0);
}
