<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\InformationModel as InfoSv;
use App\Http\Requests\InformationRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class InformationController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'information';

    /**
     * @var null
     */
    private $infoSv = null;

    /**
     * @author: dtphi .
     * InformationController constructor.
     * @param InfoSv $infoSv
     * @param array $middleware
     */
    public function __construct(InfoSv $infoSv, array $middleware = [])
    {
        $this->infoSv = $infoSv;
        parent::__construct($middleware);
        $this->_initAuthor(new InformationRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(InformationRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
      try {
            $limit       = $this->_getPerPage();
            $collections = $this->infoSv->apiGetList($data, $limit);
            
            if (isset($data['infoType']) && $data['infoType'] == 'module_special_info') {
                $pagination = [];
            } else {
                $pagination  = $this->_getTextPagination($collections);
            }

            $results = [];
            foreach ($collections as $key => $info) {
              $staticImgThum = self::$thumImgNo;
                $realPath = public_path($info->image['path']);
                if (file_exists($realPath) && (false !== realpath($realPath)) && !empty($info->image['path'])) {
                    $staticImgThum = $info->image['path'];
                }

                $results[] = [
                    'information_id' => (int)$info->information_id,
                    'image'          => $info->image,
                    'imgThum'        => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'name'           => $info->name,
                    'status'         => $info->status,
                    'status_text'    => $info->status_text,
                    'sort_order'     => $info->sort_order,
                    'date_available' => $info->date_available,
                    'created_at'     => $info->created_at
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
            $json = $this->infoSv->apiGetResourceDetail($id);
            
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param InformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InformationRequest $request)
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
     * @param InformationRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InformationRequest $request, $id = null)
    {
        try {
            $model = $this->infoSv->apiGetDetail($id);

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
            $model = $this->infoSv->apiGetDetail($id);
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

        if ($result = $this->infoSv->apiInsert($formData)) {
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

        if ($result = $this->infoSv->apiUpdate($model, $formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(InformationRequest $request)
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
    public function dropdown(InformationRequest $request)
    {
        $data = $request->all();

        $results     = $this->infoSv->apiGetList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'information_id' => $value->information_id,
                'name'           => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }
}
