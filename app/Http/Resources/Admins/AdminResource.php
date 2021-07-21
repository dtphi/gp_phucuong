<?php

namespace App\Http\Resources\Admins;

use Illuminate\Http\Resources\Json\JsonResource;
use Str;
use App\Http\Common\Tables;
use App\Models\Setting;

class AdminResource extends JsonResource
{
    public static $wrap = 'admin';

    /**
     * Transform the resource into an array_
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $setting = new Setting(); 
        $result = $setting->filterCode(Tables::RULE_SETTING_CODE)
                            ->filterKey(Tables::RULE_SETTING_KEY_DATA)->first();
        $ruleSelects = unserialize($result->value);
        $json = [];

        $this->with = [
            'fields' => 'ok',
        ];

        $res = $this->resource;
        if ($res) {
            foreach ($res->tokens()->getResults() as $permission) {
                fn_is_user_rule_permission($ruleSelects, $permission);
            }

            $json = parent::toArray($request);
            $json = array_merge($json, [
                'ruleSelect'   => fn_is_update_permission($res->id) ? serialize($ruleSelects) : []
            ]);
        }

        return $json;
    }
}
