<?php

namespace App\Http\Controllers\Api\Front\Services;

use DB;
use App\Models\GiaoXu;
use App\Models\LinhMuc;
use App\Models\LinhmucBangcap;
use App\Models\LinhmucChucthanh;
use App\Models\LinhmucThuyenchuyen;
use App\Models\LinhmucVanthu;
use App\Models\Thanh;
use App\Models\Category;
use App\Http\Common\Tables;
use App\Models\Information;
use App\Http\Resources\LinhMucs\LinhmucResource;
use App\Http\Controllers\Api\Front\Services\Contracts\BaseModel;

class Service implements BaseModel
{
	/**
	 * [$modelNewGroup description]
	 * @var null
	 */
	private $modelNewGroup = null;

	/**
	 * @author : dtphi .
	 * AdminService constructor.
	 */
	public function __construct()
	{
		$this->modelInfo     = new Information();
		$this->modelNewGroup = new Category();
		$this->modelGiaoXu   = new GiaoXu();
		$this->modelLinhMuc = new LinhMuc();
		$this->modelLinhMucChucThanh = new LinhMucChucThanh();
	}

	/**
	 * @author: dtphi .
	 * @param array $options
	 * @param int $limit
	 * @return AdminCollection
	 */
	public function apiGetList(array $options = [], $limit = 15)
	{
	}

	/**
	 * author : dtphi .
	 * @param array $options
	 * @param int $limit
	 * @return InformationCollection
	 */
	public function apiGetResourceCollection(array $options = [], $limit = 15)
	{
		// TODO: Implement apiGetResourceCollection() method.
	}

	/**
	 * @author : dtphi .
	 * @return array
	 */
	public function apiGetNewsGroupTrees()
	{
		// TODO: Implement apiGetNewsGroupTrees() method.
		$query = $this->modelNewGroup
			->select('id', 'father_id', 'newsgroupname', 'displays', 'sort')
			->orderBySortAsc();

		return [
			'total' => $query->count(),
			'data'  => $query->get()->toArray()
		];
	}

	public function getMenuCategories($parentId = 0)
	{
		$query = $this->modelNewGroup->select()
			->lfJoinDescription()
			->filterParentId($parentId)
			->filterActiveStatus()
			->orderByAscSort()
			->orderByAscParentId();

		return $query->get();
	}

	public function apiGetCategoryById($categoryId = 0)
	{
		$query = $this->modelNewGroup->select()
			->lfJoinDescription()
			->filterById($categoryId)
			->filterActiveStatus();

		return $query->first();
	}

	public function apiGetMenuCategoryIds($parentId = 0)
	{
		$query = DB::table('pc_categorys')->select('category_id')
			->where('pc_categorys.parent_id', (int)$parentId)
			->where('pc_categorys.status', '1');

		return $query->get()->toArray();
	}

	public function getMenuCategoriesToLayout($layoutId = 1)
	{
		$query = $this->modelNewGroup->select()
			->lfJoinDescription()
			->lfJoinToLayout()
			->filterLayoutId($layoutId)
			->filterActiveStatus()
			->orderByAscSort()
			->orderByAscParentId();

		return $query->get();
	}

	public function apiGetLatestInfos($limit = 5)
	{
		$query = $this->modelInfo->select('information_id')
			->orderByDescDateAvailable()
			->limit($limit);

		return $query->get();
	}

	public function apiGetPopularInfos($limit = 5)
	{
		$query = $this->modelInfo->select('information_id')
			->orderByDescViewed()
			->limit($limit);

		return $query->get();
	}

	public function apiGetInfoListByIds($data = array())
	{
		$infoType = 1;
		if (isset($data['infoType'])) {
			$infoType = (int)$data['infoType'];
		}

		$query = DB::table(Tables::$informations)->select(
			[
				'date_available',
				'sort_description',
				'image',
				Tables::$informations . '.information_id',
				'information_type',
				'name',
				'name_slug',
				'viewed',
				'vote'
			]
		)
			->leftJoin(
				Tables::$information_descriptions,
				Tables::$informations . '.information_id',
				'=',
				Tables::$information_descriptions . '.information_id'
			)
			->where('status', '=', '1')
			->where('information_type', '=', $infoType);

		if (isset($data['information_ids'])) {
			$query->whereIn(Tables::$informations . '.information_id', $data['information_ids']);
		}

		$limit = 20;
		if (isset($data['limit'])) {
			$limit = (int)$data['limit'];
		}

		$query->orderByDesc('sort_order');
		$query->orderByDesc('date_available');

		return $query->get();
	}

	public function apiGetGiaoXuList($data = array(), $limit = 5)
	{
		$query = $this->modelGiaoXu->select();

		return $query->paginate(20);
	}
	/// LINH MUC
	public function apiGetLinhmucs($data = array(), $limit = 15)
	{
		$query = DB::table(Tables::$linhmucs)->leftJoin(
			Tables::$thanhs,
			Tables::$linhmucs . '.ten_thanh_id',
			'=',
			Tables::$thanhs . '.id'
		)->leftJoin(Tables::$giao_xus, Tables::$linhmucs . '.giao_xu_id', '=', Tables::$giao_xus . '.id')
		->leftJoin(Tables::$giao_hats, Tables::$giao_xus . '.giao_hat_id', '=', Tables::$giao_hats . '.id')
		->leftJoin(Tables::$linhmuc_chucthanhs, Tables::$linhmuc_chucthanhs . '.linhmuc_id', '=', Tables::$linhmucs . '.id')
		->leftJoin(Tables::$linhmuc_thuyenchuyens, Tables::$linhmuc_thuyenchuyens . '.linhmuc_id', '=', Tables::$linhmucs . '.id')
		->leftJoin(Tables::$chuc_vus, Tables::$linhmuc_thuyenchuyens . '.chucvu_id', '=', Tables::$chuc_vus . '.id')
		->select(Tables::$chuc_vus . '.name as cv_name',
					  Tables::$linhmucs. '.id',
						Tables::$linhmucs . '.ten',
						Tables::$linhmucs . '.image',
						Tables::$linhmucs . '.ngay_thang_nam_sinh',
						Tables::$giao_xus . '.name as gx_name',
						Tables::$giao_xus . '.dia_chi',
						Tables::$giao_hats . '.name as gh_name',
						Tables::$thanhs . '.name as th_name',
						Tables::$linhmuc_chucthanhs . '.ngay_thang_nam_chuc_thanh',
		)->orderBy(Tables::$linhmucs . '.id', 'DESC');
		return $query;
	}

	public function apiGetListLinhMuc(array $options = [], $limit = 15)
	{
		// TODO: Implement apiGetList() method.
		$query = $this->apiGetLinhmucs($options);

		return $query->paginate($limit);
	}

	public function apiGetDetailLinhMuc($id = null)
	{
		/*lấy thông tin chi tiết linh mục*/
		$query = DB::table(Tables::$linhmucs)		
		->leftJoin(Tables::$linhmuc_thuyenchuyens, Tables::$linhmuc_thuyenchuyens . '.linhmuc_id', '=', Tables::$linhmucs . '.id')
		->leftJoin(Tables::$thanhs, Tables::$thanhs . '.id', '=', Tables::$linhmucs . '.ten_thanh_id')
		->leftJoin(Tables::$giao_xus, Tables::$linhmucs . '.giao_xu_id', '=', Tables::$giao_xus . '.id')
		->leftJoin(Tables::$chuc_vus, Tables::$chuc_vus . '.id', '=', Tables::$linhmuc_thuyenchuyens . '.chucvu_id')
		->leftJoin(Tables::$linhmuc_chucthanhs, Tables::$linhmuc_chucthanhs . '.linhmuc_id', '=', Tables::$linhmucs . '.id')
		->leftJoin(Tables::$giaophan_hat_xus, Tables::$giaophan_hat_xus . '.giao_xu_id', '=', Tables::$linhmucs . '.giao_xu_id')
		->leftJoin(Tables::$giaophans, Tables::$giaophans . '.id', '=', Tables::$giaophan_hat_xus . '.giao_phan_id')
		//->where(Tables::$linhmuc_thuyenchuyens . '.giaoxu_id', '=', Tables::$linhmucs . '.giao_xu_id')
		//->leftJoin(Tables::$chuc_vus, Tables::$linhmuc_thuyenchuyens . '.chucvu_id', '=', Tables::$chuc_vus . '.id')
		->where(Tables::$linhmucs . '.id', '=', $id)
		//->whereRaw(Tables::$linhmuc_thuyenchuyens . '.giaoxu_id = ' . Tables::$linhmucs . '.giao_xu_id')
		->whereColumn(Tables::$linhmuc_thuyenchuyens . '.giaoxu_id', '=', Tables::$linhmucs . '.giao_xu_id')
		->select(
			Tables::$linhmucs . '.id',
			Tables::$linhmucs . '.ten',
			Tables::$thanhs . '.name as th_name',
			Tables::$linhmucs . '.image',
			Tables::$linhmucs . '.ngay_thang_nam_sinh as ngay_sinh',
			Tables::$linhmucs . '.noi_sinh',	
			Tables::$linhmucs . '.ho_ten_cha',
			Tables::$linhmucs . '.ho_ten_me',
			Tables::$linhmucs . '.ngay_rua_toi',
			Tables::$linhmucs . '.ngay_them_suc',
			Tables::$linhmucs . '.so_cmnd',
			Tables::$linhmucs . '.ngay_cap_cmnd',
			Tables::$linhmucs . '.noicap_cmnd',
			Tables::$giao_xus . '.name as ten_xu',
			Tables::$chuc_vus . '.name as cvht_name',
			Tables::$linhmuc_chucthanhs . '.ngay_thang_nam_chuc_thanh as ngay_nhan_chuc',
			Tables::$giaophans . '.name as gp_name',
		)->first();

		/*Lấy ds chucvu thuộc linh mục hiện tại*/
		$query_other = DB::table(Tables::$linhmuc_thuyenchuyens)
		->leftJoin(Tables::$chuc_vus, Tables::$chuc_vus . '.id', '=', Tables::$linhmuc_thuyenchuyens . '.chucvu_id')
		->where(Tables::$linhmuc_thuyenchuyens . '.linhmuc_id', '=', $id)
		->whereColumn(Tables::$chuc_vus . '.id', '=', Tables::$linhmuc_thuyenchuyens . '.chucvu_id')
		->select(
			Tables::$chuc_vus . '.name as chucvu_name',
			Tables::$linhmuc_thuyenchuyens . '.from_date',
			Tables::$linhmuc_thuyenchuyens . '.to_date',
		)->distinct();
		
		$query->ds_chuc_vu = ($query_other) ? $query_other->get() : null;

		return $query;
	}
}
