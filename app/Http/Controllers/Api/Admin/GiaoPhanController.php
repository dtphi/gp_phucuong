<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanModel as GphSv;
use App\Http\Requests\GiaoPhanRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class GiaoPhanController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'giao-phan';

    /**
     * @var null
     */
    private $gphSv = null;

    /**
     * @author: dtphi .
     * GiaoPhanController constructor.
     * @param GphSv $gphSv
     * @param array $middleware
     */
    public function __construct(GphSv $gphSv, array $middleware = [])
    {
        $this->gphSv = $gphSv;
        parent::__construct($middleware);
        $this->_initAuthor(new GiaoPhanRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(GiaoPhanRequest $request)
    {
        $action = $request->query('action');
        if ($action == 'dropdown.giao.hat') {
            return $this->dropdownGiaoHat($request);
        } elseif ($action == 'dropdown.giao.diem') {
            return $this->dropdownGiaoDiem($request);
        } elseif ($action == 'dropdown.cong.doan.tu.si') {
            return $this->dropdownCongDoanTuSi($request);
        }

        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->gphSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results     = [];

            $staticImgThum = self::$thumImgNo;
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id'        => (int)$info->id,
                    'name'      => $info->name,
                    'khai_quat' => $info->khai_quat,
                    'active'    => $info->active,
                    'sort_id'   => $info->sort_id
                ];
            }

        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $json = [
            'data' => [
                'results'    => $results,
                'pagination' => $pagination,
                'page'       => $page
            ]
        ];

        return $this->respondWithCollectionPagination($json);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        try {
            $json = $this->gphSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param GiaoPhanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GiaoPhanRequest $request)
    {
        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param GiaoPhanRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GiaoPhanRequest $request, $id = null)
    {
        $data = $request->all();
        $action = $request->get('action');

        if ($action == 'create.update.hat.congdts.db') {
            try {
                $json = $this->gphSv->apiUpdateCongDoanTuSi($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.hat.xu.db') {
            try {
                $json = $this->gphSv->apiUpdateGiaoXu($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.hat.db') {
            try {
                $json = $this->gphSv->apiUpdateGiaoHat($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.dong.db') {
            try {
                $json = $this->gphSv->apiUpdateDong($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.co.so.db') {
            try {
                $json = $this->gphSv->apiUpdateCoSo($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.ban.chuyen.trach.db') {
            try {
                $json = $this->gphSv->apiUpdateBanChuyenTrach($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        }
        
        try {
            $model = $this->gphSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('Giao phan not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStoreUpdate($model, $request);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        try {
            $model = $this->gphSv->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $this->infoSv->deleteInformation($model);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $formData = $request->all();

        if ($result = $this->gphSv->apiInsert($formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStoreUpdate(&$model, &$request)
    {
        $formData = $request->all();

        if ($result = $this->gphSv->apiUpdate($model, $formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(GiaoPhanRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownGiaoHat(GiaoPhanRequest $request)
    {
        $data = $request->all();

        $results     = $this->gphSv->apiGetGiaoHatList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownGiaoDiem(GiaoPhanRequest $request)
    {
        $data = $request->all();

        $results     = $this->gphSv->apiGetGiaoDiemList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownCongDoanTuSi(GiaoPhanRequest $request)
    {
        $data = $request->all();

        $results     = $this->gphSv->apiGetCongDoanTuSiList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }
}
