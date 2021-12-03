<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GroupAlbumsModel;
use App\Http\Resources\GroupAlbums\GroupAlbumsCollection;
use App\Http\Resources\GroupAlbums\GroupAlbumsResource;
use App\Models\GroupAlbums;
use App\Http\Common\Tables;
use DB;

final class GroupAlbumsService implements BaseModel, GroupAlbumsModel
{
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new GroupAlbums();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetGroupAlbums($options);
        // get all list giaohat with perPage = -1
        if ($limit == -1) {
            $results = $query->get();
            return new \Illuminate\Pagination\LengthAwarePaginator($results, $results->count(), -1);
        } else {
            return $query->paginate($limit);
        }
    }

    public function apiGetResourceCollection(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return null;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return GiaoHatResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new GroupAlbumsResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return GiaoHat|bool|null
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

    public function apiGetGroupAlbums($data = array(), $limit = 5)
    {
        $query = $this->model->select()->orderBy('id', 'DESC');
        return $query;
    }

    
    public function apiInsert(array $data = [])
    {
        $this->model->fill($data);
        DB::beginTransaction();

        if (!$this->model->save()) {
            DB::rollBack();
            return false;
        }
        DB::commit();

        return $this->model;
    }

    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
        $this->model = $this->model->findOrFail($id);
        return $this->model;
    }

    public function apiUpdate($model, $data = [])
    {
      $model->fill($data);
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
        GroupAlbums::fcDeleteById($id);
    }

    public function apiChangeStatus($data = [])
    {
      $id = $data['id'];
      $data['status'] = (int)$data['status'];
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