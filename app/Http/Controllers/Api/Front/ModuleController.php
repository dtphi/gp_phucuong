<?php

namespace App\Http\Controllers\Api\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use App\Http\Controllers\Api\Front\Services\Contracts\SettingModel as SettingSv;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * @var null
     */
    private $settingSv = null;

    /**
     * @author: dtphi .
     * SettingController constructor.
     * @param newsGpSv $settingSv
     * @param array $middleware
     */
    public function __construct(SettingSv $settingSv, array $middleware = [])
    {
        $this->settingSv = $settingSv;
        parent::__construct($middleware);
    }

    public function showDataList(Request $request)
    {
        $params = $request->all();
        $json   = [];

        try {
            $moduleData = $this->settingSv->apiGetList(['code' => $params['code']]);
            $results    = [];
            foreach ($moduleData as $setting) {
                $value = ($setting->serialized) ? unserialize($setting->value) : $setting->value;

                $categories = $this->settingSv->apiGetCategoryByIds($value);
                foreach ($categories as $cate) {
                    $results[$setting->key_data][] = [
                        'name' => $cate->name,
                        //'children' => $children_data_2,
                        'href' => 'path=' . $cate->category_id,
                        'link' => $cate->name_slug
                    ];
                }


            }

            $json['moduleData'] = $results;

        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json($json);
    }
}
