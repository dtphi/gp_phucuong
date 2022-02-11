<?php

namespace App\Models;

use DB;
use App\Models\GiaoHat;
use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucThuyenChuyenModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiaoXu extends BaseModel
{
  use SoftDeletes;
  
	public function giaoHat()
	{
		return $this->hasOne(GiaoHat::class, $this->primaryKey, 'giao_hat_id');
	}

  public function giaohats()
	{
		return $this->belongsTo(GiaoHat::class);
	}

  public function linhmucs()
	{
		  return $this->hasMany(LinhMuc::class, 'giao_xu_id');
	}

  public function linhmucthuyenchuyens() {
      return $this->hasMany(LinhMucThuyenChuyen::class, 'giao_xu_id')->orderBy('from_date');
  }


  /**
   * @var string
   */
  protected $table = DB_PREFIX . 'giao_xus';

  protected $fillable = [
    'name',
    'ngay_thanh_lap',
    'giao_hat_id',
    'dia_chi',
    'dien_thoai',
    'email',
		'image',
    'active',
    'dan_so',
    'so_tin_huu',
    'gio_le',
    'viet',
    'latin',
    'noi_dung',
    'type',
    'update_user'
  ];

	public function getArrThuyenChuyenListAttribute($value)
	{
			$value = [];
			if ($this->linhmucthuyenchuyens) {
					foreach ($this->linhmucthuyenchuyens as $thuyenChuyen) {
							$value[] = [
									'id' => (int)$thuyenChuyen->id,
									'isCheck' => false,
									'isEdit' => 1,
									'from_giao_xu_id'      => (int)$thuyenChuyen->from_giao_xu_id,
									'fromgiaoxuName'      => $thuyenChuyen->ten_from_giao_xu,
									'from_chuc_vu_id' => (int)$thuyenChuyen->from_chuc_vu_id,
									'fromchucvuName' => $thuyenChuyen->ten_from_chuc_vu,
									'from_date' => $thuyenChuyen->from_date,
									'label_from_date' => ($thuyenChuyen->from_date)?date_format(date_create($thuyenChuyen->from_date),"d-m-Y"):'',
									'duc_cha_id' => $thuyenChuyen->duc_cha_id,
									'ducchaName' => $thuyenChuyen->ten_duc_cha,
									'to_date' => $thuyenChuyen->to_date,
									'label_to_date' => ($thuyenChuyen->to_date)?date_format(date_create($thuyenChuyen->to_date),"d-m-Y"):'',
									'chuc_vu_id' => $thuyenChuyen->chuc_vu_id,
									'chucvuName' => $thuyenChuyen->ten_to_chuc_vu,
									'giao_xu_id' => $thuyenChuyen->giao_xu_id,
									'giaoxuName' => $thuyenChuyen->ten_to_giao_xu,
									'giaoHatName' => $thuyenChuyen->ten_to_hat_xu,
									'co_so_gp_id' => $thuyenChuyen->co_so_gp_id,
									'cosogpName' => $thuyenChuyen->ten_co_so,
									'dong_id' => $thuyenChuyen->dong_id,
									'dongName' => $thuyenChuyen->ten_dong,
									'ban_chuyen_trach_id' => $thuyenChuyen->ban_chuyen_trach_id,
									'banchuyentrachName' => $thuyenChuyen->ten_ban_chuyen_trach,
									'du_hoc' => $thuyenChuyen->du_hoc,
									'quoc_gia' => $thuyenChuyen->quoc_gia,
									'ghi_chu' => $thuyenChuyen->ghi_chu,
									'active' => $thuyenChuyen->active,
							];
					}
			}

			return $value;
	}

  public function getNoiDungAttribute($value)
  {
      return htmlspecialchars_decode($value);
  }

  public function getTenGiaoHatAttribute($value) 
  {
    $value = ($this->giaoHat) ? $this->giaoHat->name : '';

    return $value;
  }

  public function scopeName($query, $request) {
      return  $query->where('name', 'LIKE', '%' . $request->input('query') . '%');
  }
  
}
