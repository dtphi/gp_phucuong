<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\AdminModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Resources\Admins\AdminCollection;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;
use DB;
use App\Models\PersonalAccessToken;
use Str;
use Auth;
use App\Http\Common\Tables;

final class AdminService implements BaseModel, AdminModel
{
    /**
     * @var Admin|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new Admin();
    }

    /**
     * @author: dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetList(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->model->orderByDescById();

        return $query->paginate($limit);
    }

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return new AdminCollection($this->apiGetList($options, $limit));
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return AdminResource
     */
    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
        $this->model = $this->model->findOrFail($id);

        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return AdminResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new AdminResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return Admin|bool|null
     */
    public function apiInsertOrUpdate(array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.
        $this->model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();
        /*$actions = ['list', 'add', 'edit', 'delete'];
        $rules = [
            'setting' => $actions,
            'thanh' => $actions,
            'news.group' => $actions,
            'linh.muc.van.thu' => $actions,
            'linh.muc.thuyen.chuyen' => $actions,
            'linh.muc.bang.cap' => $actions,
            'linh.muc.chuc.thanh' => $actions,
            'linh.muc' => $actions,
            'le.chinh' => $actions,
            'chuc.vu' => $actions,
            'giao.phan' => $actions,
            'giao.hat' => $actions,
            'giao.xu' => $actions,
            'giao.diem' => $actions,
            'giao.phan.co.so' => $actions,
            'cong.doan.tu.si' => $actions,
            'dong' => $actions,
            'tin.tuc' => $actions,
        ];
        */
        
        if (!$this->model->save()) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    /**
     * update permission.
     */
    public function apiPermissionUpdate(array $allows = [], $tokenablId = null)
    {
        // TODO: Implement apiInsertOrUpdate() method.

        DB::beginTransaction();
        try {
            if (fn_is_admin_permission() && fn_is_update_permission($tokenablId)) {
                PersonalAccessToken::fcDeleteByTokenableId($tokenablId);
                foreach ($allows as $key => $allow) {
                    $abilities = [];
                    $keyName = Str::replace('_', '.', $key);

                    if ($allow['all']) {
                        $abilities[] = $keyName . ':*';
                    } else {
                        foreach ($allow['abilities'] as $action => $abilitie) {
                            if ($abilitie) {
                                $abilities[] = $keyName . ':' . $action;
                            }
                        }
                    }

                    if (!empty($abilities))
                        $this->model->createToken(Tables::PREFIX_ACCESS_NAME . $keyName, $abilities); 
                }
            }
        } catch (\Exceptions $e) {

            DB::rollBack();

            return false;
        }

        DB::commit();

        return true;
    }
}
