<?php

namespace App\Http\Resources\LinhMucThuyenChuyens;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel as LinhMucSv;

class LinhMucThuyenChuyenCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function dateCheckMonthDay($datestring)
    {
      $splitDateTime=explode(' ',$datestring)[0];
      $splitDate=explode('-',$splitDateTime);
      if ($splitDate[1]==='0'){
        // $date=date_create($datestring);
        // date_add($date,date_interval_create_from_date_string("1 year"));
        return $splitDate[0];
      }
  
      else if ($splitDate[2]==='0') {
        // $date=date_create($datestring);
        // date_add($date,date_interval_create_from_date_string("1 month"));
        return $splitDate[0].'-'.$splitDate[1];
      }
      else return date_format(date_create($datestring), "Y-m-d");
      
    }
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
              'label_from_date' => ($info->from_date) ? $this->dateCheckMonthDay($info->from_date) : '',
              'ducchaName' => $info->ten_duc_cha,
              'label_to_date' => ($info->to_date) ? $this->dateCheckMonthDay($info->to_date) : '',
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
