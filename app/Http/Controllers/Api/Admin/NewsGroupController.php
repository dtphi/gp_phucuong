<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Helpers\Helper;
use App\Models\NewsGroup;
use Illuminate\Http\Request;
use App\Http\Requests\NewsGroupRequest;
use App\Http\Resources\NewsGroups\NewsGroupResource;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;


/**
 * Class NewsGroupController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class NewsGroupController extends ApiController
{
    protected $resourceName = 'newsgroup';

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/stores
     */
    public function index(Request $request)
    {
        $data = [
            'sort'      => 'stores.code',
            'direction' => 'desc',
            'page'      => $request['page'] ?: 1
        ];

        if (isset($request['q']) && !empty($request['q'])) {
            $data['search'] = $request['q'];
        }
        if (isset($request['sort']) && !empty($request['sort'])) {
            $data['sort'] = 'stores.' . $request['sort'];
        }
        if (isset($request['direction']) && !empty($request['direction'])) {
            $data['direction'] = $request['direction'];
        }

        $newsGroups     = NewsGroup::getNewsGroups($data);
        $newsGroupTrees = $this->generateTree($newsGroups['data']);

        return Helper::successResponse([
            'results' => $newsGroupTrees
        ]);
    }

    /**
     * [generateTree description]
     * @param  [type]  $data   [description]
     * @param  integer $parent [description]
     * @param  integer $depth [description]
     * @return [type]          [description]
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

    public function show(Request $request, $id = null)
    {
        return new NewsGroupResource(NewsGroup::findOrFail($id));
    }

    public function store(NewsGroupRequest $request)
    {
        $model = new NewsGroup();

        $storeResponse = $this->__handleStore($model, $request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        return $this->respondCreated("New {$this->resourceName} created.", $model->id);
    }

    public function update(NewsGroupRequest $request, $id = null)
    {
        try {
            $model = NewsGroup::findOrFail($id);

        } catch (ModelNotFoundException $e) {
            Log::debug('User not found, Request ID = ' . $id);

            return $this->respondNotFound();
        }

        return $this->__handleStore($model, $request);
    }

    public function destroy(Request $request, $id = null)
    {
        try {
            $model = NewsGroup::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound("No {$this->resourceName} found.");
        }

        $model->destroy($id);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    private function __handleStore(NewsGroup $model, &$request)
    {
        $requestParams            = $request->all();
        $requestParams['user_id'] = $request->user()->id;
        $model->fill($requestParams);

        /**
         * Save news group with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if (!$model->save()) {
            DB::rollBack();

            return $this->respondBadRequest();
        }

        DB::commit();

        return $this->respondUpdated();
    }
}
