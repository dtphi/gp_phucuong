<?php

namespace App\Http\Resources\LinhMucThuyenChuyens;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinhMucThuyenChuyenCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $results = [];
        foreach ($this->collection as $info) {
            $results[] = [
              'id' => (int)$info->id,
              'isCheck' => false,
              'isEdit' => 1,
              'from_date' => $info->from_date,
              'to_date' => $info->to_date,
              'chuc_vu_id' => $info->chuc_vu_id,
              'giao_xu_id' => ($info->giao_xu_id) ? $info->giao_xu_id : 0,
              'fromGiaoXuName'      => $info->ten_from_giao_xu,
              'fromchucvuName' => $info->ten_from_chuc_vu,
              'label_from_date' => ($info->from_date) ? date_format(date_create($info->from_date), "Y-m-d") : '',
              'ducchaName' => $info->ten_duc_cha,
              'label_to_date' => ($info->to_date) ? date_format(date_create($info->to_date), "Y-m-d") : '',
              'chucvuName' => $info->ten_to_chuc_vu,
              'giao_xu_url' => url('admin/giao-xus/edit/' . $info->giao_xu_id),
              'giaoxuName' => $info->ten_to_giao_xu,
              'cosogpName' => $info->ten_co_so,
              'co_so_id' => $info->co_so_gp_id,
              'co_so_status' => $info->trang_thai_co_so,
              'dong_id' => $info->dong_id,
              'ban_chuyen_trach_id' => $info->ban_chuyen_trach_id,
              'dongName' => $info->ten_dong,
              'banchuyentrachName' => $info->ten_ban_chuyen_trach,
              'du_hoc' => $info->du_hoc,
              'quoc_gia' => $info->quoc_gia,
              'ghi_chu' => $info->ghi_chu,
              'active' => $info->active,
              'active_text' => $info->active ? 'Xảy ra' : 'Ẩn',
              'chuc_vu_active' => $info->chuc_vu_active
            ];
        }
        
        return [
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
