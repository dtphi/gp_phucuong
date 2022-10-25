<?php

namespace App\Http\Resources\GiaoXus;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GiaoXuCollection extends ResourceCollection
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
        return $splitDate[1].'-'.$splitDate[0];
      }
      else return date_format(date_create($datestring), "d-m-Y");
      
    }
    public function toArray($request)
    {
				$results = [];
				foreach ($this->collection as $thuyenChuyen) {
						$results[] = [
							'id' => (int)$thuyenChuyen->id,
							'isCheck' => false,
							'isEdit' => 1,
							'from_date' => $thuyenChuyen->from_date,		
							'to_date' => $thuyenChuyen->to_date,
							'linhMucName' => $thuyenChuyen->tenThanh . ' ' . $thuyenChuyen->TenLinhMuc,
							'linh_muc_id' => $thuyenChuyen->linh_muc_id,
							'fromGiaoXuName'      => $thuyenChuyen->ten_from_giao_xu,
							'fromchucvuName' => $thuyenChuyen->ten_from_chuc_vu,
							'label_from_date' => ($thuyenChuyen->from_date)?$this->dateCheckMonthDay($thuyenChuyen->from_date):'',
							'ducchaName' => $thuyenChuyen->ten_duc_cha,
							'label_to_date' => ($thuyenChuyen->to_date)?$this->dateCheckMonthDay($thuyenChuyen->to_date):'',
							'chucvuName' => $thuyenChuyen->ten_to_chuc_vu,
							'chuc_vu_id' => $thuyenChuyen->chuc_vu_id,
							'giao_xu_url' => url('admin/giao-xus/edit/' . $thuyenChuyen->giao_xu_id),
							'giaoxuName' => $thuyenChuyen->ten_to_giao_xu,
							'giao_xu_id' => $thuyenChuyen->giao_xu_id, 
							'cosogpName' => $thuyenChuyen->ten_co_so,
							'dongName' => $thuyenChuyen->ten_dong,
							'banchuyentrachName' => $thuyenChuyen->ten_ban_chuyen_trach,
							'du_hoc' => $thuyenChuyen->du_hoc,
							'quoc_gia' => $thuyenChuyen->quoc_gia,
							'ghi_chu' => $thuyenChuyen->ghi_chu,
							'active' => $thuyenChuyen->active,
							'active_text' => $thuyenChuyen->active?'Xảy ra':'Ẩn',
							'chuc_vu_active' => $thuyenChuyen->chuc_vu_active
						];
				}

				return [
						'results' => $results,
						'errors'  => [],
						'status'  => 1000
				];
	 }
}
