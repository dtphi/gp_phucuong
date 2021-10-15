<?php

namespace App\Http\Controllers\Api\Front\Base;

use Image;
use Storage;
use Exception;
use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Http\File;
use App\Http\Common\Tables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Api\Front\Services\Service;
use App\Http\Controllers\Api\Front\Services\SettingService;

class ApiController extends Controller
{
	public static $thumImgNo = '/images/default_image.jpg';

	public static $thumSize = 200;

	public static $menuFullInfos = [63, 205, 207, 208, 209, 210, 211, 213, 214, 216, 220, 241, 248, 273];

	public static $tmbThumbDir = '.tmb';

	public static $disk = 'public';

	/**
	 * @var Sv|null
	 */
	protected $sv = null;

	/**
	 * @var null
	 */
	private $settingSv = null;

	// Success
	const RESPONSE_OK = 2000;
	const RESPONSE_CREATED = 2001;
	const RESPONSE_UPDATED = 2002;
	const RESPONSE_DELETED = 2003;
	const RESPONSE_IN_PROGRESS = 2004;

	/**
	 * @author : dtphi .
	 * ApiController constructor.
	 * @param array $middleware
	 */
	public function __construct(array $middleware = [])
	{
		parent::__construct($middleware);
		$this->sv        = new Service();
		$this->settingSv = new SettingService();
	}

	public function getThumbnail($imgOrigin, $thumbSize = 0, $thumbHeight = 0, $force = false)
	{
		$imgThumUrl = '';
		if ($thumbSize <= 0) {
			$thumbSize = self::$thumSize;
		}

		$staticThumImg = rawurldecode(trim($imgOrigin, '/'));
		if (!file_exists(public_path('/' . $staticThumImg))) {
			$staticThumImg = trim(self::$thumImgNo, '/');
		}

		if ($force) {
			return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
		}

		if ((int)$thumbHeight > 0) {
			$thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
			if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
				return Storage::url($thumbDir);
			}

			return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
		} else {
			$thumbDir = self::$tmbThumbDir . '/' . $staticThumImg;
			if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
				return Storage::url($thumbDir);
			}

			return $this->forceThumbnail($staticThumImg, $thumbSize);
		}
	}

	public function forceThumbnail($staticThumImg, $thumbSize = 200, $thumbHeight = 0)
	{
		$fileResize = new File(public_path($staticThumImg));
		$extension  = $fileResize->extension();
		$thumbDir   = self::$tmbThumbDir . '/' . $staticThumImg;
		if ((int)$thumbHeight > 0) {
			$thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
			$resize   = Image::make($fileResize)->resize($thumbSize, $thumbHeight)->encode($extension);
		} else {
			$resize = Image::make($fileResize)->resize($thumbSize, null, function ($constraint) {
				$constraint->aspectRatio();
			})->encode($extension);
		}

		Storage::disk(self::$disk)->put($thumbDir, $resize->__toString());

		return Storage::url($thumbDir);
	}

	/**
	 * Get config app.
	 */
	public function getSetting(Request $request)
	{
		$requestParams = $request->get('params');

		$pathName = isset($requestParams['pathName']) ? $requestParams['pathName'] : 'home';
		$pathName = trim($pathName, '/');

		try {
			$menus      = [];
			$categories = $this->sv->getMenuCategories(0);

			foreach ($categories as $cate) {
				// Level 2
				$children_data_2 = array();

				if (!empty($cate->name)) {
					$children_2 = $this->sv->getMenuCategories($cate->category_id);

					foreach ($children_2 as $child_2) {
						$path_2 = 'path=' . $cate->category_id . '_' . $child_2->category_id;
						$link_2 = $cate->name_slug . '/' . $child_2->name_slug;
						// Level 3
						$children_data_3 = array();

						if (!empty($child_2->name)) {
							$children_3 = $this->sv->getMenuCategories($child_2->category_id);

							foreach ($children_3 as $child_3) {
								$path_3 = $path_2 . '_' . $child_3->category_id;
								$link_3 = $link_2 . '/' . $child_3->name_slug;
								// Level 4
								$children_data_4 = array();

								$children_4 = $this->sv->getMenuCategories($child_3->category_id);

								foreach ($children_4 as $child_4) {
									$path_4 = $path_3 . '_' . $child_4->category_id;
									$link_4 = $link_3 . '/' . $child_4->name_slug;
									// Level 5
									$children_data_5 = array();

									$children_5 = $this->sv->getMenuCategories($child_4->category_id);

									foreach ($children_5 as $child_5) {
										$path_5 = $path_4 . '_' . $child_5->category_id;
										$link_5 = $link_4 . '/' . $child_5->name_slug;

										// Level 5-1
										$filter_data = array(
											'filter_category_id'  => $child_5->category_id,
											'filter_sub_category' => true
										);

										$children_data_5[] = array(
											'name' => $child_5->name,
											'href' => $path_5,
											'link' => $link_5
										);
									}

									// Level 4 - 1
									$filter_data = array(
										'filter_category_id'  => $child_4->category_id,
										'filter_sub_category' => true
									);

									$children_data_4[] = array(
										'name'     => $child_4->name,
										'children' => $children_data_5,
										'href'     => $path_4,
										'link'     => $link_4
									);
								}

								// Level 3 -1
								$filter_data = array(
									'filter_category_id'  => $child_3->category_id,
									'filter_sub_category' => true
								);

								$children_data_3[] = array(
									'name'     => $child_3->name,
									'children' => $children_data_4,
									'href'     => $path_3,
									'link'     => $link_3
								);
							}
						}

						// Level 2 - 1
						$filter_data = array(
							'filter_category_id'  => $child_2->category_id,
							'filter_sub_category' => true
						);

						$children_data_2[] = array(
							'name'     => $child_2->name,
							'children' => $children_data_3,
							'href'     => $path_2,
							'link'     => $link_2
						);
					}
				}

				// Level 1
				$menus[] = array(
					'name'     => $cate->name,
					'children' => $children_data_2,
					'href'     => 'path=' . $cate->category_id,
					'link'     => $cate->name_slug
				);
			}

			$menuLayout_1 = [];

			$appImgPath      = '/upload/app';
			$data['appList'] = [
				[
					'sort'         => 0,
					'title'        => 'App website gppc',
					'img'          => $appImgPath . '/app_website_gppc.png',
					'hrefAppStore' => '/',
					'hrefChPlay'   => '/'
				],
				[
					'sort'         => 1,
					'title'        => 'App sách nói công giáo',
					'img'          => $appImgPath . '/app_sach_noi_cong_giao.jpg',
					'hrefAppStore' => '/',
					'hrefChPlay'   => '/'
				],
				[
					'sort'         => 2,
					'title'        => 'App tìm nhà thờ gần nhất',
					'img'          => $appImgPath . '/app_tim_nha_tho.jpg',
					'hrefAppStore' => 'https://apps.apple.com/us/app/tìm-nhà-thờ-gần-nhất/id1485257114?ls=1',
					'hrefChPlay'   => 'https://play.google.com/store/apps/details?id=com.phucuong.churchfinder&hl=en_AU&gl=US'
				],
			];

			$settings = $this->settingSv->apiGetSettingByCodes([
				Tables::$moduleSystemCode
			]);
			$systems = [];
			if ($settings) {
				$systems = $settings->reduce(function ($carry, $item) {
					$value = '';

					switch ($item->serialized) {
						case 1:
							$value = unserialize($item->value);
							break;

						case 2:
							$value = json_decode($item->value);
							break;

						default:
							$value = $item->value;
							break;
					}

					$carry[$item->key_data] = $value;

					return $carry;
				});
			}

			$data['banner']  = isset($systems['module_system_banners']) ? url($systems['module_system_banners']['image']) : url('Image/NewPicture/home_banners/banner_image.png');
			$data['logo'] = isset($systems['module_system_logos']) ? url($systems['module_system_logos']) : url('/front/img/logo.png');
			$data['phone'] = isset($systems['module_system_phones']) ? $systems['module_system_phones'] : '';
			$data['phoneBgColor'] = isset($systems['module_system_content_backgd_phones']) ? $systems['module_system_content_backgd_phones'] : '#3aacda';
			$data['email'] = isset($systems['module_system_emails']) ? $systems['module_system_emails'] : '';
			$data['headerTitle'] = isset($systems['module_system_header_titles']) ? $systems['module_system_header_titles'] : '';
			$data['headerBgColor'] = isset($systems['module_system_content_backgd_header_titles']) ? $systems['module_system_content_backgd_header_titles'] : '#0071bc';
			$data['logoTitle'] = isset($systems['module_system_logo_titles']) ? $systems['module_system_logo_titles'] : '';
			$data['logoTitle1'] = isset($systems['module_system_logo_title_1s']) ? $systems['module_system_logo_title_1s'] : '';
			$data['logoBgColor'] = isset($systems['module_system_content_backgd_logos']) ? $systems['module_system_content_backgd_logos'] : '#2354a4';
			$data['contentBgColor'] = isset($systems['module_system_con_background_colors']) ? $systems['module_system_con_background_colors'] : 'rgba(128, 128, 128, 0.07)';

			$data['menus']   = $menus;
			$data['menus_1'] = $menuLayout_1;

			$data['modules'] = $this->_getModules($request);

			$data['pages'] = [
				'home'  => [
					'title' => 'Trang chủ',
					'id'    => 1,
				],
				'video' => [
					'title' => 'Trang video',
					'id'    => 2
				],
				'news'  => [
					'title' => 'Trang tin tức',
					'id'    => 3
				]
			];

			$data['infoLasteds']  = $this->getLastedInfoList($request);
			$data['infoPopulars'] = $this->getPopularList($request);
		} catch (HandlerMsgCommon $e) {
			throw $e->render();
		}

		return response()->json($data);
	}

	protected function _getModules(&$request)
	{
		$layout  = json_decode($request->get('layout'));
		$page    = isset($layout->page) ? $layout->page : 'home';
		$modules = [
			'module_noi_bat',
			'module_thong_bao',
			'module_category_left_side_bar',
			'module_special_info',
			'module_tin_giao_hoi_viet_nam',
			'module_tin_giao_hoi',
			'module_tin_giao_phan',
			'module_loi_chua',
			'module_van_kien',
			'module_category_icon_side_bar'
		];

		$results = [];

		foreach ($modules as $module) {
			$moduleData       = $this->settingSv->apiGetList(['code' => $module]);
			$results[$module] = [];

			foreach ($moduleData as $setting) {
				$value = ($setting->serialized) ? unserialize($setting->value) : $setting->value;

				if (!empty($value)) {
					if (is_array($value[0])) {
						$results[$module][$setting->key_data] = $value;
					} else {
						$categories = $this->settingSv->apiGetCategoryByIds($value);
						foreach ($categories as $cate) {
							$results[$module][$setting->key_data][] = [
								'name' => $cate->name,
								'href' => 'path=' . $cate->category_id,
								'link' => $cate->name_slug
							];
						}
					}
				} else {
					$results[$module][$setting->key_data] = [];
				}
			}
		}

		return $results;
	}

	public function getLastedInfoList(Request $request)
	{
		$json = [];

		$list = $this->sv->apiGetLatestInfos(20)->toArray();

		if (!empty($list)) {
			$infoIds = array_reduce($list, function ($carry, $item) {
				$carry[] = $item['information_id'];

				return $carry;
			});

			if (!empty($infoIds)) {
				$params                    = $request->all();
				$params['information_ids'] = $infoIds;

				$results = $this->sv->apiGetInfoListByIds($params);

				$json = [];
				foreach ($results as $info) {
					$sortDes = html_entity_decode($info->sort_description);

					$json[] = [
						'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
						'description'      => html_entity_decode($info->sort_description),
						'sort_description' => Str::substr($sortDes, 0, 100),
						'information_id'   => $info->information_id,
						'name'             => $info->name,
						'name_slug'        => $info->name_slug,
						'sort_name'        => Str::substr($info->name, 0, 28),
						'viewed'           => $info->viewed,
						'vote'             => $info->vote
					];
				}
			}
		}

		return $json;
	}

	public function getPopularList(Request $request)
	{
		$json = [];

		if (!empty($request->query('slug'))) {
			return $this->list($request);
		}

		$list = $this->sv->apiGetPopularInfos(20)->toArray();

		if (!empty($list)) {
			$infoIds = array_reduce($list, function ($carry, $item) {
				$carry[] = $item['information_id'];

				return $carry;
			});

			if (!empty($infoIds)) {
				$params                    = $request->all();
				$params['information_ids'] = $infoIds;

				$results = $this->sv->apiGetInfoListByIds($params);

				$json = [];
				foreach ($results as $info) {
					$sortDes = html_entity_decode($info->sort_description);

					$json[] = [
						'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
						'description'      => html_entity_decode($info->sort_description),
						'sort_description' => Str::substr($sortDes, 0, 100),
						'information_id'   => $info->information_id,
						'name'             => $info->name,
						'name_slug'        => $info->name_slug,
						'sort_name'        => Str::substr($info->name, 0, 25),
						'viewed'           => $info->viewed,
						'vote'             => $info->vote
					];
				}
			}
		}

		return $json;
	}

	/**
	 * @author : dtphi .
	 * @param $data
	 * @param int $parent
	 * @param int $depth
	 * @return array
	 */
	protected function generateTree($data, $parent = -1, $depth = 0)
	{
		$newsGroupTree = [];

		for ($i = 0, $ni = count($data); $i < $ni; $i++) {
			if ($data[$i]['father_id'] == $parent) {
				$newsGroupTree[$data[$i]['id']]['id']            = $data[$i]['id'];
				$newsGroupTree[$data[$i]['id']]['fatherId']      = $data[$i]['father_id'];
				$newsGroupTree[$data[$i]['id']]['newsgroupname'] = $data[$i]['newsgroupname'];

				$newsGroupTree[$data[$i]['id']]['children'] = $this->generateTree(
					$data,
					$data[$i]['id'],
					$depth + 1
				);
			}
		}

		return $newsGroupTree;
	}

	public function getGiaoXuList(Request $request)
	{
		$page = 1;
		if ($request->query('page')) {
			$page = $request->query('page');
		}
		try {
			$results = [];
			$collections = $this->sv->apiGetGiaoXuList();
			$pagination = $this->_getTextPagination($collections);

			foreach ($collections as $key => $info) {
				$results[] = [
					'id' => (int) $info->id,
					'name' => $info->name,
					'hrefDetail' => url('giao-xu/chi-tiet/' . $info->id),
					'image'	=> !empty($info->image) ? url($info->image): url('Image/Picture/Images/CacGiaoXu/Hat-BenCat/RachKien-Gx-Thuml.png'),
					'gio_le' => html_entity_decode($info->gio_le) ?? "Chưa cập nhật",
					'dia_chi' => html_entity_decode($info->dia_chi) ?? "Chưa cập nhật",
					'email' => $info->email ?? "Chưa cập nhật",
					'dien_thoai' => $info->dien_thoai ?? "Chưa cập nhật",
					'so_tin_huu' => $info->so_tin_huu ?? "Chưa cập nhật",
					'dan_so' => $info->dan_so ?? "Chưa cập nhật",
				];
			}

			$json = [
				'data' => [
					'results'    => $results,
					'pagination' => $pagination,
					'page'       => $page
				]
			];
		} catch (HandlerMsgCommon $e) {
			$json = [
				'data' => [
					'results'    => [],
					'pagination' => [],
					'msg'       => $e->render()
				]
			];
		}

		return $this->respondWithCollectionPagination($json);
	}

	public function getGiaoXuDetail(Request $request, $giaoXuId = null)
	{
		$info = $this->sv->apiGetDetailGiaoXu($giaoXuId);
		$linhMucs = $this->sv->apiGetLinhMucListByGiaoXuId($giaoXuId);
		$emptyStr = 'Chưa cập nhật';

		$linhMucTienNhiem = [];
		$linhMucChanhXu = $this->sv->apiGetLinhMucChanhXuByGiaoXuId($giaoXuId);
		$linhMucPhoXu = $this->sv->apiGetLinhMucPhoXuByGiaoXuId($giaoXuId);
		$arrLmIds = [];
		foreach ($linhMucs as $linhMuc) {
			if (!in_array($linhMuc->linh_muc_id, $arrLmIds)) {
				$linhMucTienNhiem[] = $linhMuc->ten_thanh . ' ' .$linhMuc->ten_linh_muc;
			}
			array_push($arrLmIds, $linhMuc->linh_muc_id);
		}
		if (empty($linhMucTienNhiem))
			$linhMucTienNhiem = ['Chưa cập nhật'];

		$imgChanhXu = '';
		if ($linhMucChanhXu) {
			$nameChanhXu = isset($linhMucChanhXu->ten_thanh)?$linhMucChanhXu->ten_thanh.'-'.$linhMucChanhXu->ten_linh_muc:$emptyStr;
			$imgChanhXu = isset($linhMucChanhXu->linhMuc->image) ? url($linhMucChanhXu->linhMuc->image) : url('images/linh-muc.jpg');
		}
		$imgPhoXu = '';
		if ($linhMucPhoXu){
			$namePhoXu = isset($linhMucPhoXu->ten_thanh)?$linhMucPhoXu->ten_thanh.'-'.$linhMucPhoXu->ten_linh_muc:$emptyStr;
			$imgPhoXu = isset($linhMucPhoXu->linhMuc->image) ? url($linhMucPhoXu->linhMuc->image) : url('images/linh-muc.jpg');
		}
		$json['results'] = [];
		if ($info) {
			$defaultImage = 'Image/Picture/Images/CacGiaoXu/Hat-BenCat/RachKien-Gx-Thuml.png';
			$endStr = ' <a href="javascript:void(0)" onclick="$bvModal.show(\'giaoXuHistoryFull\')"  style="color:#007bff !important">>>>Xem toàn bộ</a>';
			$subNoiDung = \Illuminate\Support\Str::limit($info->noi_dung, 1650, $endStr);
			$json['results'] = [
				'id' => $giaoXuId,
				'name' => $info->name,
				'image' => !empty($info->image) ? url($info->image): url($defaultImage),
				'noi_dung' => html_entity_decode($info->noi_dung),
				'sub_noi_dung' => $subNoiDung,
				'so_tin_huu' => $info->so_tin_huu ?? $emptyStr,
				'dan_so' => 'Dân số giáo xứ: ' .  $info->dan_so ?? $emptyStr,
				'gio_le' => html_entity_decode($info->gio_le)?? $emptyStr,
				'dia_chi' => html_entity_decode($info->dia_chi) ?? $emptyStr,
				'dien_thoai' => $info->dien_thoai ?? $emptyStr,
				'email' => $info->email ?? $emptyStr,
				'linh_muc_tien_nhiem' => implode('<br>',$linhMucTienNhiem),
				'chanh_xu' => $nameChanhXu,
				'img_chanh_xu' => $imgChanhXu,
				'pho_xu' => $namePhoXu,
				'img_pho_xu' => $imgPhoXu,
				'ngay_thanh_lap' => $emptyStr,
				'bon_mang' => $emptyStr
			];
		}
		return $json;
	}

	/// lấy danh sách linh mục
	public function respondWithCollectionPagination($data)
	{
		return $data;
	}

	protected function _getTextPagination(LengthAwarePaginator $paginator)
	{
		$data = [];

		if (
			$paginator instanceof LengthAwarePaginator && $paginator->count()
		) {
			$data = $paginator->toArray();

			unset($data['data']);
		}

		return $data;
	}

	public function getLinhMucList(Request $request)
	{
		$data = $request->all();
		$page = 1; // set page dau = 1
		if ($request->query('page')) {
			$page = $request->query('page'); // neu request co page thi gan gia tri
		}

		try {
			$limit = 5;
			$collections = $this->sv->apiGetListLinhMuc($data, $limit);
			$pagination = $this->_getTextPagination($collections);
			$results = [];
			$staticImgThum = self::$thumImgNo;
			foreach ($collections as $key => $info) {
			/* 	if(!empty($info->image) && file_exists(public_path($info->image))) {
					$info->image = $staticImgThum ;
				} */
				$results[] = [
					'id' => (int) $info->id,
					'ten' => $info->ten,
					'href_giaoxu' => (isset($info->id_giao_xu)) ? url('giao-xu/chi-tiet/' . $info->id_giao_xu): "javascript:void(0);",
					'nam_sinh' => \Carbon\Carbon::parse($info->ngay_thang_nam_sinh)->format('d-m-Y') ?? "Chưa cập nhật",
					'image'	=> !empty($info->image) ? url($info->image): url('images/linh-muc.jpg'),
					'giao_xu' => $info->gx_name ?? "Chưa cập nhật",
					'dia_chi' => $info->dia_chi ?? "Chưa cập nhật",
					'giao_hat' => $info->gh_name ?? "Chưa cập nhật",
					'ten_thanh' => $info->th_name ?? "Chưa cập nhật",
					'ngay_nhan_chuc' => \Carbon\Carbon::parse($info->ngay_thang_nam_chuc_thanh)->format('d-m-Y') ?? "Chưa cập nhật",
					'chuc_vu' => $info->cvht_name ?? "Chưa cập nhật",
				];
			}
		} catch (HandlerMsgCommon $e) {
			throw $e->render();
		}
		$json = [
			'data' => [
				'results'    => $results,
				'pagination' => $pagination,
				'page'       => $page
			]
		];

		return $this->respondWithCollectionPagination($json);
	}

	public function getLinhMucDetail($id = null, Request $request)
	{
		try {
			$infos = $this->sv->apiGetDetailLinhMuc($id);
			$thuyenChuyens = $infos->arr_thuyen_chuyen_list;
			$chucVuHienTai = '';
			if (!empty($thuyenChuyens)) {
				$endThuyenChuyen = end($thuyenChuyens);
				$chucVuHienTai = $endThuyenChuyen['chucvuName'];
			}
			$emptyStr = 'Chưa cập nhật';

			$results[] = [
				'id' => (int) $infos->id,
				'ten' => $infos->ten,
				'ten_thanh' => $infos->ten_thanh ?? $emptyStr,
				'nam_sinh' => $infos->ngay_sinh ?? $emptyStr,
				'image'	=> !empty($infos->image) ? url($infos->image) : url('images/linh-muc.jpg'),
				'giao_xu' => $infos->ten_xu ?? $emptyStr,
				'dia_chi' => $infos->noi_sinh ?? $emptyStr,
				'giao_phan' => $infos->gp_name ?? $emptyStr,	
				'ho_ten_cha' => $infos->ho_ten_cha ?? $emptyStr,
				'ho_ten_me' => $infos->ho_ten_me ?? $emptyStr,
				'ngay_rua_toi' => ($infos->ngay_rua_toi)?date_format(date_create($infos->ngay_rua_toi),"d-m-Y"):$emptyStr,
				'ngay_them_suc' => ($infos->ngay_them_suc)?date_format(date_create($infos->ngay_them_suc),"d-m-Y"):'',
				'so_cmnd' => $infos->so_cmnd ?? $emptyStr,
				'ngay_cap_cmnd' => $infos->ngay_cap_cmnd ?? $emptyStr,
				'noi_cap_cmnd' => $infos->noi_cap_cmnd ?? $emptyStr,
				'cv_hien_tai' => $chucVuHienTai ?? $emptyStr,
				'ds_chuc_vu' => $thuyenChuyens ?? "",
				'ds_chuc_thanh' => $infos->arr_chuc_thanh_list ?? "",
			];
			}
		catch (HandlerMsgCommon $e) {
			throw $e->render();
		}
		return  $results;
	}
}
