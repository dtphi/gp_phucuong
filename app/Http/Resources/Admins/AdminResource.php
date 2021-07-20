<?php

namespace App\Http\Resources\Admins;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $actions = ['list', 'add', 'edit', 'delete'];
        $rules = [
            'setting' => $actions,
            'thanh' => $actions,
            'news_group' => $actions,
            'linh_muc_van_thu' => $actions,
            'linh_muc_thuyen_chuyen' => $actions,
            'linh_muc_bang_cap' => $actions,
            'linh_muc_chuc_thanh' => $actions,
            'linh_muc' => $actions,
            'le_chinh' => $actions,
            'chuc_vu' => $actions,
            'giao_phan' => $actions,
            'giao_hat' => $actions,
            'giao_xu' => $actions,
            'giao_diem' => $actions,
            'giao_phan_co_so' => $actions,
            'cong_doan_tu_si' => $actions,
            'dong' => $actions,
            'tin_tuc' => $actions,
        ];

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
            $json = parent::toArray($request);
            $json = array_merge($json, [
                'ruleSelect'       => $ruleSelects
            ]);
        }

        return $json;
    }
}
