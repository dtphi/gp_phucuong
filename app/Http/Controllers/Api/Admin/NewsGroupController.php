<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Helpers\Helper;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\NewsGroupModel as newsGpSv;
use App\Http\Requests\NewsGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class NewsGroupController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class NewsGroupController extends ApiController
{
    protected $resourceName = 'newsgroup';

    /**
     * @var null
     */
    private $newsGpSv = null;

    /**
     * @author: dtphi .
     * NewsGroupController constructor.
     * @param newsGpSv $newsGpSv
     * @param array $middleware
     */
    public function __construct(newsGpSv $newsGpSv, array $middleware = [])
    {
        $this->newsGpSv = $newsGpSv;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $pagination = [];
        $results = [];
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $newsGroups = $this->newsGpSv->apiGetList($data, $limit);
            $pagination = $this->_getTextPagination($newsGroups);

            $results = [];
            foreach ($newsGroups as $key => $newsGroup) {
                $results[] = [
                    'category_name' => $newsGroup->category_name,
                    'sort_order'    => $newsGroup->sort_order,
                    'category_id'   => $newsGroup->category_id
                ];
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return Helper::successResponse([
            'results' => $results,
            'pagination' => $pagination,
            'page' => $page
        ]);
    }

    /**
     * [_getTextPagination description]
     * @param  LengthAwarePaginator $paginator [description]
     * @return [type]                          [description]
     */
    protected function _getTextPagination(LengthAwarePaginator $paginator)
    {
        $data = [];

        if ($paginator instanceof LengthAwarePaginator && $paginator->count()) {
            $data = $paginator->toArray();

            unset($data['data']);
        }

        return $data;
    }

    /**
     * @author : dtphi .
     * @param $data
     * @param int $parent
     * @param int $depth
     * @return array
     */
    public function generateTree($data, $parent = -1, $depth = 0)
    {
        $newsGroupTree = [];

        for ($i = 0, $ni = count($data); $i < $ni; $i++) {
            if ($data[$i]['father_id'] == $parent) {
                $newsGroupTree[$data[$i]['id']]['id']            = $data[$i]['id'];
                $newsGroupTree[$data[$i]['id']]['fatherId']      = $data[$i]['father_id'];
                $newsGroupTree[$data[$i]['id']]['newsgroupname'] = $data[$i]['newsgroupname'];
                $newsGroupTree[$data[$i]['id']]['children']      = $this->generateTree($data, $data[$i]['id'],
                    $depth + 1);
            }
        }

        return $newsGroupTree;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        try {
            $json = $this->newsGpSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param NewsGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NewsGroupRequest $request)
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
     * @param NewsGroupRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NewsGroupRequest $request, $id = null)
    {
        try {
            $model = $this->newsGpSv->getCateogryById($id);

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
            $model = $this->newsGpSv->getCateogryById($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $this->newsGpSv->deleteCategory($model);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $requestParams = $request->all();

        if ($result = $this->newsGpSv->apiInsert($requestParams)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStoreUpdate(&$model, &$request)
    {
        $requestParams = $request->all();

        if ($result = $this->newsGpSv->apiUpdate($model, $requestParams)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    public function dropdown(Request $request)
    {
        $data = $request->all();

        $results = $this->newsGpSv->apiGetCategories($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'category_id' => $value->category_id,
                'name' => strip_tags(html_entity_decode($value->name, ENT_QUOTES, 'UTF-8')),
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }
}
