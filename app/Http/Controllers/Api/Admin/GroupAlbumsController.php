<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\GroupAlbumsModel as GrAlbumsSv;
use App\Http\Requests\GroupAlbumsRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class GroupAlbumsController extends ApiController
{   
    protected $resourceName = 'group-albums';

    private $grAlbumsSv = null;

    public function __construct(GrAlbumsSv $grAlbumsSv, array $middleware = [])
    {
        $this->grAlbumsSv = $grAlbumsSv;
        parent::__construct($middleware);
        $this->_initAuthor(new GroupAlbumsRequest);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GroupAlbumsRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->grAlbumsSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];

            foreach ($collections as $key => $info) {
                $results[] = [
                  'id'         => (int)$info->id,
                  'group_name' => $info->group_name,
                  'status'     => $info->status,
                  'sort_id'    => $info->sort_id,           
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
