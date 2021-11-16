<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;
use App\Models\RestrictIp;
use App\Http\Common\Tables;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\RestrictIps\RestrictIpResource;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\RestrictIpModel;

final class RestrictIpService implements BaseModel, RestrictIpModel
{
    private $model = null;

    public function __construct()
    {
        $this->model = new RestrictIp();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetRestrictIps($options);
        // get all list giaohat with perPage = -1
        if ($limit == -1) {
            $results = $query->get();
            return new \Illuminate\Pagination\LengthAwarePaginator($results, $results->count(), -1);
        } else {
            return $query->paginate($limit);
        }
    }

    public function apiGetRestrictIps($data = array(), $limit = 5)
    {
      $query = $this->model->select()->orderBy('id', 'DESC');
      return $query;
    }
    public function checkExists(array $data = []) {
      $values = $data['ip'];
      $checkIp = $this->model->where('ip', '=', $values)->first();
      return $checkIp;
    }

    public function apiInsert(array $data = [])
    {
        if($this->checkExists($data) != null) {
          return false;
        }
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
        return new RestrictIpResource($this->apiGetDetail($id));
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

    /* UPDATE IP */
    public function apiUpdate($model, $data = [])
    {
      if($this->checkExists($data) != null) {
          return false;
      }
      $this->model->fill($data);
      DB::beginTransaction();
      if (!$this->model->save()) {
        DB::rollBack();
        return false;
      }
      DB::commit();
      return $this->model;
    }

    // DELETE RESTRICT IP
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
      RestrictIp::fcDeleteById($id);
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
      if($data['status'] == 0) {
        $data['active'] = 1;
      }else {
        $data['active'] = 0;
      }
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
