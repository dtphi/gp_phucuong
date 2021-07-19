<?php

namespace App\Http\Controllers\Api\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel as HomeSv;
use App\Http\Controllers\Api\Front\Services\Contracts\SettingModel as SettingSv;
use Illuminate\Http\Request;
use App\Http\Common\Tables;
use Str;

class HomeController extends Controller
{
    /**
     * @var string
     */
    protected $resourceName = 'home';

    /**
     * @var HomeSv|null
     */
    private $homeSv = null;

    /**
     * 
     */
    private $settingSv = null;

    /**
     * @author : dtphi .
     * HomeController constructor.
     * @param HomeSv $homeSv
     * @param array $middleware
     */
    public function __construct(HomeSv $homeSv, SettingSv $settingSv, array $middleware = [])
    {
        $this->homeSv = $homeSv;
        $this->settingSv = $settingSv;
        parent::__construct($middleware);
    }

    /**
     * [getServiceContext:  ]
     * @return [type] [description]
     */
    public function getServiceContext()
    {
        return $this->homeSv;
    }

    public function index()
    {
        try {
            $data = [];
            $settings = $this->settingSv->apiGetSettingByCodes(Tables::$moduleBannerCode);
            if ($settings) {
                foreach ($settings as $key => $setting) {
                    $values = ($setting->serialized) ? unserialize($setting->value) : $setting->value;
                    $imgThumUrl = $this->getThumbnail(!empty($values['image']) ? $values['image']: self::$thumImgNo, 273, 170);

                    $data[] = [
                        'sort' => isset($values['sort']) ? (int)$values['sort']: $key,
                        'img' => $values['image'],
                        'imgThumbUrl' => url($imgThumUrl),
                        'url' => $values['url'],
                        'title' => Str::upper($values['title'])
                    ];
                }
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'pageLists' => $data
        ]);
    }
}
