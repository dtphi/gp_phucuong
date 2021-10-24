<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel as LinhMucSv;
use App\Http\Requests\LinhmucRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;
use App\Http\Common\Tables;

class LinhMucController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'linh-muc';

    /**
     * @var null
     */
    private $linhMucSv = null;

    /**
     * @author: dtphi .
     * InformationController constructor.
     * @param LinhMucSv $linhMucSv
     * @param array $middleware
     */
    public function __construct(LinhmucRequest $request, LinhMucSv $linhMucSv, array $middleware = [])
    {
        $this->linhMucSv = $linhMucSv;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(LinhmucRequest $request)
    {
        $action = $request->query('action');
        if ($action == 'dropdown.giao.xu') {
            return $this->dropdownGiaoXu($request);
        } elseif ($action == 'dropdown.ten.thanh') {
            return $this->dropdownThanh($request);
        } elseif ($action == 'dropdown.chuc.vu') {
            return $this->dropdownChucVu($request);
        } elseif ($action == 'dropdown.duc.cha') {
            return $this->dropdownDucCha($request);
        } elseif ($action == 'dropdown.co.so.giao.phan') {
            return $this->dropdownCoSoGiaoPhan($request);
        } elseif ($action == 'dropdown.dong') {
            return $this->dropdownDong($request);
        } elseif ($action == 'dropdown.ban.chuyen.trach') {
            return $this->dropdownBanChuyenTrach($request);
        }

        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->linhMucSv->apiGetList($data, $limit);
          
            $pagination  = $this->_getTextPagination($collections);
            $results     = [];
          
            

            
            foreach ($collections as $key => $info) {
                $staticImgThum = self::$thumImgNo;
                if (!empty($info->image) && file_exists(public_path($info->image))) {                
                  $staticImgThum = $info->image;
                }
                $results[] = [
                    'id'         => (int)$info->id,
                    'ten'        => $info->ten,
                    'ten_thanh'  => $info->ten_thanh,
                    'image'      => $info->image,
                    'phone' => $info->phone,
                    'email' => $info->email,
                    'imgThum'    => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'active'     => Tables::$linhMucStatus[(int)$info->active],
                    'trieu_dong' => Tables::$trieuDongs[(int)$info->trieu_dong],
                    'ngay_sinh' => $info->ngay_thang_nam_sinh,
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
            $json = $this->linhMucSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param LinhmucRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinhmucRequest $request)
    {
        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->information_id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param LinhmucRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinhmucRequest $request, $id = null)
    {
        $data = $request->all();
        $action = $request->get('action');

        if ($action == 'create.update.bang.cap.db') {
            try {
                $json = $this->linhMucSv->apiUpdateBangCap($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.chuc.thanh.db') {
            try {
                $json = $this->linhMucSv->apiUpdateChucThanh($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.van.thu.db') {
            try {
                $json = $this->linhMucSv->apiUpdateVanThu($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.thuyen.chuyen.db') {
            try {
                $json = $this->linhMucSv->apiUpdateThuyenChuyen($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        }

        try {
            $model = $this->linhMucSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

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
            $model = $this->linhMucSv->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $this->linhMucSv->deleteInformation($model);

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

        if ($result = $this->linhMucSv->apiInsert($formData)) {
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

        if ($result = $this->linhMucSv->apiUpdate($model, $formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(LinhmucRequest $request)
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
    public function dropdownGiaoXu(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetGiaoXuList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownThanh(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetThanhList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownChucVu(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetChucVuList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownDucCha(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetDucChaList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'         => $value->id,
                'name'       => $value->ten,
                'is_duc_cha' => $value->is_duc_cha
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownCoSoGiaoPhan(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetCoSoGiaoPhanList($data);
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
    public function dropdownDong(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetDongList($data);
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
    public function dropdownBanChuyenTrach(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetBanChuyenTrachList($data);
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
