<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoXuModel as GxSv;
use App\Http\Requests\GiaoXuRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class GiaoXuController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'giao-xu';

    /**
     * @var null
     */
    private $gxSv = null;

    /**
     * @author: dtphi .
     * GiaoXuController constructor.
     * @param GxSv $gxSv
     * @param array $middleware
     */
    public function __construct(GxSv $gxSv, array $middleware = [])
    {
        $this->gxSv = $gxSv;
        parent::__construct($middleware);
        $this->_initAuthor(new GiaoXuRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(GiaoXuRequest $request)
    {
        $data = $request->all();
        $page = 1;
        
        if($request->session()->exists('id_giao_hat')) {
            if($request->session()->get('id_giao_hat') != $data['idGiaoHat'] && $data['idGiaoHat'] != 0) {
                session()->put('id_giao_hat', $data['idGiaoHat']);
            }else if($data['idGiaoHat'] == -1) {
                $request->session()->forget('id_giao_hat');
            }else {
                $data['idGiaoHat'] = $request->session()->get('id_giao_hat');
            }  
        }else if($data['idGiaoHat'] != 0){
            session()->put('id_giao_hat', $data['idGiaoHat']);
        }

        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->gxSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            if($data['idGiaoHat'] == 0 || $data['idGiaoHat'] == -1) {
                foreach ($collections as $key => $info) {
                    $staticImgThum = self::$thumImgNo;
                                    if (!empty($info->image) && file_exists(public_path($info->image))) {                 
                                        $staticImgThum = $info->image;
                                    }
                    $results[] = [
                        'id' => (int)$info->id,
                        'hrefDetail' => '/giao-xus/edit/' . $info->id,
                        'name'           => $info->name,
                        'dia_chi'         => $info->dia_chi,
                        'dien_thoai'          => $info->dien_thoai,
                        'image'      => $info->image,
                        'imgThum'    => url($this->getThumbnail($staticImgThum, 0, 40)),
                        'email'    => $info->email,
                        'active'     => $info->active,
                        'danso' => $info->dan_so,
                        'sotinhuu'     => $info->so_tin_huu,
                        'giole' => $info->gio_le,
                        'viet' => $info->viet,
                        'noidung' => $info->noi_dung,
                        'updatetime' => $info->updatetime
                    ];
                }
            } else {
                foreach ($collections as $key => $info) {
                    $staticImgThum = self::$thumImgNo;
                                    if (!empty($info->giaoXu->image) && file_exists(public_path($info->giaoXu->image))) {                 
                                        $staticImgThum = $info->giaoXu->image;
                                    }
                    $results[] = [
                        'id' => (int)$info->id,
                        'hrefDetail' => '/giao-xus/edit/' . $info->giaoXu->id,
                        'name'           => $info->giaoXu->name,
                        'dia_chi'         => $info->giaoXu->dia_chi,
                        'dien_thoai'          => $info->giaoXu->dien_thoai,
                        'image'      => $info->giaoXu->image,
                        'imgThum'    => url($this->getThumbnail($staticImgThum, 0, 40)),
                        'email'    => $info->giaoXu->email,
                        'active'     => $info->giaoXu->active,
                        'danso' => $info->giaoXu->dan_so,
                        'sotinhuu'     => $info->giaoXu->so_tin_huu,
                        'giole' => $info->giaoXu->gio_le,
                        'viet' => $info->giaoXu->viet,
                        'noidung' => $info->giaoXu->noi_dung,
                        'updatetime' => $info->giaoXu->updatetime
                    ];
                }
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
            $json = $this->gxSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param GiaoXuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GiaoXuRequest $request)
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
     * @param GiaoXuRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GiaoXuRequest $request, $id = null)
    {
        try {
            $model = $this->gxSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('Giao xu not found, Request ID = ' . $id);

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
            $model = $this->gxSv->apiGetDetail($id);
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

        if ($result = $this->gxSv->apiInsertOrUpdate($formData)) {
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
        if ($result = $this->gxSv->apiUpdate($model, $formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(GiaoXuRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }

    public function listGiaoHats(GiaoXuRequest $request) {
        try {
            $results = [];
            $collections = $this->gxSv->apiGetListGiaoHat();
            foreach ($collections as $key => $info) {
                $results[] = [
                  'value' => $info->id,
                  'text' => $info->name
                ];
            } 
            $json = [
              'data' => [
                'results'    => $results,
              ]
            ];
          } catch (HandlerMsgCommon $e) {
            $json = [
              'data' => [
                'results'   => [],
                'msg'       => $e->render()
              ]
            ];
        }

        return $this->respondWithCollectionPagination($json);
    }

    public function listGiaoXuByIdGiaoHat(GiaoXuRequest $request, $id = null) {
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->gxSv->apiGetListByIdGiaoHat($id, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];

            foreach ($collections as $key => $info) {
                $staticImgThum = self::$thumImgNo;
								if (!empty($info->giaoXu->image) && file_exists(public_path($info->giaoXu->image))) {                 
									$staticImgThum = $info->giaoXu->image;
								}
                $results[] = [
                    'id' => (int)$info->id,
                    'hrefDetail' => '/giao-xus/edit/' . $info->giaoXu->id,
                    'name'           => $info->giaoXu->name,
                    'dia_chi'         => $info->giaoXu->dia_chi,
                    'dien_thoai'          => $info->giaoXu->dien_thoai,
										'image'      => $info->giaoXu->image,
                    'imgThum'    => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'email'    => $info->giaoXu->email,
                    'active'     => $info->giaoXu->active,
                    'danso' => $info->giaoXu->dan_so,
                    'sotinhuu'     => $info->giaoXu->so_tin_huu,
                    'giole' => $info->giaoXu->gio_le,
                    'viet' => $info->giaoXu->viet,
                    'noidung' => $info->giaoXu->noi_dung,
                    'updatetime' => $info->giaoXu->updatetime
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

}
