<?php

namespace App\Http\Controllers\Api\Store;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;

/**
 * Class CatalogController
 *
 * @package App\Http\Controllers\Api\Store
 */
class CatalogController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/catalog/get-list
     */
    public function getList()
    {
        return Helper::successResponse(
            ['catalogList' => Catalog::where('deleted_at', null)
                ->select('manufacturer_name', 'manufacturer_image', 'url')
                ->get()
                ->toArray()
            ]
        );
    }
}
