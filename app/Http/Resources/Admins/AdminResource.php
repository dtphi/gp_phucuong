<?php

namespace App\Http\Resources\Admins;

use Illuminate\Http\Resources\Json\JsonResource;
use Str;
use App\Http\Common\Tables;

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
        $actionSelects = ['list' => false, 'add' => false, 'edit' => false, 'delete' => false];
        $ruleSelects = [
            'setting' => ['abilities' => $actionSelects, 'all' => false],
            'thanh' => ['abilities' => $actionSelects, 'all' => false],
            'news_group' => ['abilities' => $actionSelects, 'all' => false],
            'linh_muc_van_thu' => ['abilities' => $actionSelects, 'all' => false],
            'linh_muc_thuyen_chuyen' => ['abilities' => $actionSelects, 'all' => false],
            'linh_muc_bang_cap' => ['abilities' => $actionSelects, 'all' => false],
            'linh_muc_chuc_thanh' => ['abilities' => $actionSelects, 'all' => false],
            'linh_muc' => ['abilities' => $actionSelects, 'all' => false],
            'le_chinh' => ['abilities' => $actionSelects, 'all' => false],
            'chuc_vu' => ['abilities' => $actionSelects, 'all' => false],
            'giao_phan' => ['abilities' => $actionSelects, 'all' => false],
            'giao_hat' => ['abilities' => $actionSelects, 'all' => false],
            'giao_xu' => ['abilities' => $actionSelects, 'all' => false],
            'giao_diem' => ['abilities' => $actionSelects, 'all' => false],
            'giao_phan_co_so' => ['abilities' => $actionSelects, 'all' => false],
            'cong_doan_tu_si' => ['abilities' => $actionSelects, 'all' => false],
            'dong' => ['abilities' => $actionSelects, 'all' => false],
            'tin_tuc' => ['abilities' => $actionSelects, 'all' => false],
        ];

        $json = [];

        $this->with = [
            'fields' => 'ok',
        ];

        $res = $this->resource;
        if ($res) {
            foreach ($res->tokens()->getResults() as $permission) {
                $keyName = trim(Str::replace(Tables::PREFIX_ACCESS_NAME, ' ', $permission->name));
                $keyName = Str::replace('.', '_', $keyName);
                $abilities = $permission->abilities;
                foreach ($abilities as $abilitie) {
                    $action = trim(Str::replace($keyName . ':', ' ', $abilitie));
    
                    if ($action == '*') {
                        if (array_key_exists($keyName, $ruleSelects)) {
                            $ruleSelects[$keyName]['all'] = true;
                            $ruleSelects[$keyName]['abilities']['list'] = true;
                            $ruleSelects[$keyName]['abilities']['add'] = true;
                            $ruleSelects[$keyName]['abilities']['edit'] = true;
                            $ruleSelects[$keyName]['abilities']['delete'] = true;
                        }
                    } else {
                        if (array_key_exists($action, $ruleSelects[$keyName]['abilities'])) {
                            $ruleSelects[$keyName]['abilities'][$action] = true;
                        }
                    }
                }
            }

            $json = parent::toArray($request);//dd($res);
            $json = array_merge($json, [
                'ruleSelect'   => fn_is_update_permission($res->id) ? $ruleSelects: []
            ]);
        }

        return $json;
    }
}
