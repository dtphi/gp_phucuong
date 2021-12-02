<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Albums;
use Illuminate\Http\Request;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Requests\AlbumsRequest;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\AlbumsModel as AlbumsSv;

class AlbumsController extends ApiController
{   
    private $albumsSv = null;

    protected $resourceName = 'albums';

    public function __construct(AlbumsSv $albumsSv, array $middleware = []) {
      $this->albumsSv = $albumsSv;
      parent::__construct($middleware);
      $this->_initAuthor(new AlbumsRequest);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AlbumsRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if($request->query('page')) {
          $page = (int)$request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->albumsSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            foreach ($collections as $key => $info) {
                $staticImgThum = self::$thumImgNo; 
                $realPath = public_path($info->image_origin['path']);      

                if (file_exists($realPath) && (false !== realpath($realPath)) && !empty($info->image_origin['path'])) {           
                  $staticImgThum = $info->image_origin['path'];
                }
                $results[] = [
                    'id' => (int)$info->id,
                    'albums_name' => $info->albums_name,
                    'status' => $info->status,
                    'sort_id' => $info->sort_id,
                    'imgThum' => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'name_group_albums' => $info->groupAlbums ? $info->groupAlbums->group_name : '',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumsRequest $request)
    {
      $storeResponse = $this->__handleStore($request);

      if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
          return $storeResponse;
      }

      $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

      return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    private function __handleStore(&$request)
    {
        $formData = $request->all();
        
        if ($result = $this->albumsSv->apiInsert($formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        try {
          $json = $this->albumsSv->apiGetResourceDetail($id);
            
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumsRequest $request, $id = null)
    {
        try {
            $model = $this->albumsSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStoreUpdate($model, $request);
    }

    private function __handleStoreUpdate(&$model, &$request)
    {
        $formData = $request->all();

        if ($result = $this->albumsSv->apiUpdate($model, $formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $model = $this->albumsSv->apiGetDetail($id);
      } catch (HandlerMsgCommon $e) {
        throw $e->render();
      }
      $this->albumsSv->apiDelete($model);
      return $this->respondDeleted("{$this->resourceName} deleted.");
    }
}
