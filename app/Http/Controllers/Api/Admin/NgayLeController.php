<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\NgayLeModel as NgayLeSv;
use App\Http\Requests\NgayLeRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class NgayLeController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'ngay-le';

    /**
     * @var null
     */
    private $ngayLeSv = null;

    /**
     * NgayLeController constructor.
     * @param NgayLeSv $ngayLeSv
     * @param array $middleware
     */

    public function __construct(NgayLeSv $ngayLeSv, array $middleware = [])
    {
        $this->ngayLeSv = $ngayLeSv;
        parent::__construct($middleware);
				$this->_initAuthor(new NgayLeRequest);
    }

    public function index(NgayLeRequest $request)
    {
       
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {

            $limit       = $this->_getPerPage();
            $collections = $this->ngayLeSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'code'           => $info->code,
                    'solar_day'         => $info->solar_day .  '',
                    'solar_month'    => $info->solar_month. '',
                    'lunar_day'   => $info->lunar_day . '',
                    'lunar_month'    => $info->lunar_month . '',
                    'ten_le'     => $info->ten_le,
                    'loai_le' => $info->loai_le,
                    'bac_le' => $info->bac_le,
                    'hanh' => $info->hanh,
                    'nam_ai' => $info->nam_ai,
                    'nam_aii' => $info->nam_aii,
                    'nam_bi' => $info->nam_bi,
                    'nam_bii' => $info->nam_bii,
                    'nam_ci' => $info->nam_ci,
                    'nam_cii' => $info->nam_cii,
                    'update_at' =>$info->update_at,
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
            $json = $this->ngayLeSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    public function store(NgayLeRequest $request)
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
     * @param NgayLeRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NgayLeRequest $request, $id = null)
    {
        try {
            $model = $this->ngayLeSv->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            Log::debug('Ngay Le not found, Request ID = ' . $id);

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
            $model = $this->ngayLeSv->apiGetDetail($id);
            $model->forceDelete();
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

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

        if ($result = $this->ngayLeSv->apiInsert($formData)) {
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
        if ($result = $this->ngayLeSv->apiInsertOrUpdate($formData, $model)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    
}
