<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;
use App\Models\Albums;
use App\Http\Common\Tables;
use App\Http\Resources\Albums\AlbumsResource;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\AlbumsModel;

final class AlbumsService implements BaseModel, AlbumsModel
{
    private $model = null;

    public function __construct()
    {
        $this->model = new Albums();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetAlbums($options);
        if ($limit == -1) {
            $results = $query->get();
            return new \Illuminate\Pagination\LengthAwarePaginator($results, $results->count(), -1);
        } else {
            return $query->paginate($limit);
        }
    }

    public function apiGetAlbums($data = array(), $limit = 5)
    {

      $query = $this->model->with('groupAlbums')->orderBy('id', 'DESC');
      return $query;
    }

    public function apiInsert(array $data = [])
    {
        $this->model->fill($data);
        if (isset($data['albums_images']) && !empty($data['albums_images'])) {
          
          $this->model->image = serialize($data['albums_images']['value']);
        }
        
        if (isset($data['image_path'])) {
          $this->model->image_origin  = $data['image_path'];
          $this->model->image_thumb   = $data['image_thumb'];
        }

        DB::beginTransaction();
        if (!$this->model->save()) {
            DB::rollBack();
            return false;
        }
        DB::commit();

        return $this->model;
    }

    public function apiGetResourceCollection(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return null;
    }

    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
         $this->model = $this->model->findOrFail($id);
        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return LeChinhResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new AlbumsResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return LeChinh|bool|null
     */
    public function apiInsertOrUpdate(array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.
        $this->model->fill($data);
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if (!$this->model->save()) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return $this->model;
    }

    
    public function apiUpdate($model, $data = [])
    {
        $model->fill($data);

        if (isset($data['group_images']) && !empty($data['group_images'])) {
          $model->image = serialize($data['group_images']['value']);
        }

        if (isset($data['image_path'])) {
        
            $model->image_origin  = $data['image_path'];
            $model->image_thumb   = $data['image_thumb'];
        }
      
        DB::beginTransaction();
        if (!$model->save()) {
          DB::rollBack();
          return false;
        }
        DB::commit();
        return $this->model;
    }

 
    public function apiDelete($model)
    {
      DB::beginTransaction();
      try {
        $id = $model->id;
        $this->_deleteById($id);
        DB::commit();
      } catch (\Exceptions $e) {
        DB::rollBack();
        throw $e;
        return false;
      }
    }

    private function _deleteById($id)
    {
      Albums::fcDeleteById($id);
    }

    public function apiGetSearch(array $options = [], $limit = 5, $queryIps = '')
    {
      // TODO: Implement apiGetList() method.
      $query = $this->apiGetRestrictIpsWithSearch($options, $limit, $queryIps);
      // get all list giaohat with perPage = -1
      if ($limit == -1) {
        $results = $query->get();
        return new \Illuminate\Pagination\LengthAwarePaginator($results, $results->count(), -1);
      } else {
        return $query->paginate($limit);
      }
    }

    public function apiGetRestrictIpsWithSearch($data = array(), $limit = 5, $queryIps)
    {
      $query = $this->model->select()->where('ip', 'like', '%' . $queryIps . '%')
      ->orWhere('active', 'like', '%' . $queryIps . '%')->orderBy('id', 'DESC');
      return $query;
    }

    //apiChangeStatus
    public function apiChangeStatus($data = [])
    {
      $id = $data['id'];
      $data['active'] = (int)$data['status'];
      $this->model = $this->model->findOrFail($id);
      $this->model->fill($data);
      DB::beginTransaction();
      if (!$this->model->save()) {
        DB::rollBack();
        return false;
      }
      DB::commit();
      return $this->model;
    }
  }
