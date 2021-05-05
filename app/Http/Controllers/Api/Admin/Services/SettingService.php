<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\SettingModel;
use App\Http\Resources\Settings\SettingCollection;
use App\Http\Resources\Settings\SettingResource;
use App\Models\Setting;
use DB;

final class SettingService implements BaseModel, SettingModel 
{
    public function apiGetList(array $options = [], $limit = 15) {}

    public function apiGetResourceCollection(array $options = [], $limit = 15){}

    public function apiGetDetail($id = null){}

    public function apiGetResourceDetail($id = null){}

    public function apiInsertOrUpdate(array $data = []){
        // TODO: Implement apiInsertOrUpdate() method.

        /**
         * Save setting with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();
        try {
            //Setting::forceDeleteByCode($data['code']);
            $model = new Setting();
            $model->code = $data['code']; 
            
            foreach($data['settings'] as $setting) {
                $model->key_data = $setting['key'];
                $model->value = $setting['value'];
                $model->serialized = $setting['serialized'];

                $model->save();
                //Setting::forceInsert($data['code'], $setting['key'], $setting['value'], $setting['serialized']);
            }
        } catch (\Exception $e) {

            //DB::rollBack();

            return false;
        }

        DB::commit();

        return true;
    }
}
