<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel as LinhMucSv;
use App\Http\Requests\LinhmucRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;
use App\Http\Common\Tables;

class LinhMucController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'linh-muc';

    /**
     * @var null
     */
    private $linhMucSv = null;

    /**
     * @author: dtphi .
     * InformationController constructor.
     * @param LinhMucSv $linhMucSv
     * @param array $middleware
     */
    public function __construct(LinhMucSv $linhMucSv, array $middleware = [])
    {
        $this->linhMucSv = $linhMucSv;
        parent::__construct($middleware);
        $this->_initAuthor(new LinhmucRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(LinhmucRequest $request)
    {
        $action = $request->query('action');
        if ($action == 'dropdown.giao.xu') {
            return $this->dropdownGiaoXu($request);
        } elseif ($action == 'dropdown.ten.thanh') {
            return $this->dropdownThanh($request);
        } elseif ($action == 'dropdown.chuc.vu') {
            return $this->dropdownChucVu($request);
        } elseif ($action == 'dropdown.duc.cha') {
            return $this->dropdownDucCha($request);
        } elseif ($action == 'dropdown.co.so.giao.phan') {
            return $this->dropdownCoSoGiaoPhan($request);
        } elseif ($action == 'dropdown.dong') {
            return $this->dropdownDong($request);
        } elseif ($action == 'dropdown.ban.chuyen.trach') {
            return $this->dropdownBanChuyenTrach($request);
        }elseif ($action == 'dropdown.linh.muc') {
					return $this->dropdownLinhMuc($request);
			}

        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        $data['s_name'] = $request->query('name');
        $data['s_phone'] = $request->query('phone');
        $data['s_email'] = $request->query('email');
        $data['s_ngay_sinh'] = $request->query('ngay_sinh');
        $data['s_trieu_dong'] = $request->query('trieu_dong');
        $data['s_noi_sinh'] = $request->query('noi_sinh');
        $data['s_noi_rua_toi'] = $request->query('noi_rua_toi');
        $data['s_noi_them_suc'] = $request->query('noi_them_suc');
        $data['s_cmnd'] = $request->query('cmnd');
        $data['s_active'] = $request->query('active');

        try {
            $limit       = $this->_getPerPage();
            $collections = $this->linhMucSv->apiGetList($data, $limit);
          
            $pagination  = $this->_getTextPagination($collections);
            $results     = [];
            
            foreach ($collections as $key => $info) {
                $staticImgThum = self::$thumImgNo;
                if (!empty($info->image) && file_exists(public_path($info->image))) {                
                  $staticImgThum = $info->image;
                }
                $results[] = [
                    'id'         => (int)$info->id,
                    'ten'        => $info->ten,
                    'ten_thanh'  => $info->ten_thanh,
                    'image'      => $info->image,
                    'phone' => $info->phone,
                    'email' => $info->email,
                    'imgThum'    => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'active'     => Tables::$linhMucStatus[(int)$info->active],
                    'trieu_dong' => Tables::$trieuDongs[(int)$info->trieu_dong],
                    'ngay_sinh' => $info->ngay_thang_nam_sinh,
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

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        try {
            $json = $this->linhMucSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param LinhmucRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinhmucRequest $request)
    {
        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->information_id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param LinhmucRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinhmucRequest $request, $id = null)
    {
        $data = $request->all();
        $action = $request->get('action');
				if ($action == 'create.update.bang.cap.db') {
            try {
                $json = $this->linhMucSv->apiUpdateBangCap($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
            return $json;
        } elseif ($action == 'create.update.chuc.thanh.db') {
            try {
                $json = $this->linhMucSv->apiUpdateChucThanh($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
    
            return $json;
        } elseif ($action == 'create.update.van.thu.db') {
            try {
                $json = $this->linhMucSv->apiUpdateVanThu($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render(); 
            }
    
            return $json;
        } elseif ($action == 'update.thuyen.chuyen') {
            try {
                $json = $this->linhMucSv->apiUpdateThuyenChuyen($data);
            } catch (HandlerMsgCommon $e) {
                throw $e->render();
            }
            return $json;
        } elseif ($action == 'update.bo.nhiem') {
					try {
							$json = $this->linhMucSv->apiUpdate($data);
					} catch (HandlerMsgCommon $e) {
							throw $e->render();
					}
					return $json;
				} elseif ($action == 'update.active.bo.nhiem') {
					try {
							$json = $this->linhMucSv->apiUpdateActiveBoNhiem($data['bo_nhiem']);
					} catch (HandlerMsgCommon $e) {
							throw $e->render();
					}
				}elseif($action == 'update.active.lm.thuyen.chuyen'){
					try {
						  $json = $this->linhMucSv->apiUpdateActiveLmThuyenChuyen($data['lm_thuyen_chuyen']);
					} catch (HandlerMsgCommon $e) {
							throw $e->render();
					}
				}elseif($action == 'update.active.thuyen.chuyen'){
					try {
						  $json = $this->linhMucSv->apiUpdateActiveThuyenChuyen($data['lm_thuyen_chuyen']);
					} catch (HandlerMsgCommon $e) {
							throw $e->render();
					}
					return $json;
			}elseif($action == 'addThuyenChuyen') {
				try {
					$json = $this->linhMucSv->apiAddThuyenChuyen($data);
				} catch (HandlerMsgCommon $e) {
						throw $e->render();
				}
				return $json;
				}elseif($action == 'addBoNhiem') {
					try {
						$json = $this->linhMucSv->apiAddBoNhiem($data);
					} catch (HandlerMsgCommon $e) {
							throw $e->render();
					}
					return $json;
				}else {
					try {
						$model = $this->linhMucSv->apiGetDetail($id);

				} catch (HandlerMsgCommon $e) {
						Log::debug('User not found, Request ID = ' . $id);

						throw $e->render();
				}
				return $this->__handleStoreUpdate($model, $request);
			}
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        try {
            $model = $this->linhMucSv->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $this->linhMucSv->deleteInformation($model);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $formData = $request->all();

        if ($result = $this->linhMucSv->apiInsert($formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStoreUpdate(&$model, &$request)
    {
        $formData = $request->all();
        if ($result = $this->linhMucSv->apiUpdate($model, $formData)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(LinhmucRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownGiaoXu(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetGiaoXuList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name . '|' . $value->dia_chi,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownThanh(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetThanhList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownChucVu(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetChucVuList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownDucCha(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetDucChaList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'         => $value->id,
                'name'       => $value->ten,
                'is_duc_cha' => $value->is_duc_cha
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownCoSoGiaoPhan(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetCoSoGiaoPhanList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownDong(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetDongList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdownBanChuyenTrach(LinhmucRequest $request)
    {
        $data = $request->all();

        $results     = $this->linhMucSv->apiGetBanChuyenTrachList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->name
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

		public function dropdownLinhMuc(LinhmucRequest $request)
    {
        $data = $request->all();
				
        $results     = $this->linhMucSv->apiGetLinhMucList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'id'   => $value->id,
                'name' => $value->ten_thanh . ' ' . $value->ten,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

		public function listLinhMucThuyenChuyen($infoId = null, LinhmucRequest $request) 
		{
				try {
					$collections = $this->linhMucSv->apiGetThuyenChuyen($infoId);
					$results = [];

					foreach ($collections as $key => $info) {
							$results[] = [
									'id' => (int)$info->id,
									'isCheck' => false,
                  'isEdit' => 1,
									'from_date' => $info->from_date,		
									'to_date' => $info->to_date,
									'chuc_vu_id' => $info->chuc_vu_id,
									'giao_xu_id' => $info->giao_xu_id,
									'fromGiaoXuName'      => $info->ten_from_giao_xu,
									'fromchucvuName' => $info->ten_from_chuc_vu,
									'label_from_date' => ($info->from_date)?date_format(date_create($info->from_date),"Y-m-d"):'',
									'ducchaName' => $info->ten_duc_cha,
									'label_to_date' => ($info->to_date)?date_format(date_create($info->to_date),"Y-m-d"):'',
									'chucvuName' => $info->ten_to_chuc_vu,
									'giao_xu_url' => url('admin/giao-xus/edit/' . $info->giao_xu_id),
									'giaoxuName' => $info->ten_to_giao_xu,
									'cosogpName' => $info->ten_co_so,
									'co_so_id' => $info->co_so_gp_id,
									'dong_id' => $info->dong_id,
									'ban_chuyen_trach_id' => $info->ban_chuyen_trach_id,
									'dongName' => $info->ten_dong,
									'banchuyentrachName' => $info->ten_ban_chuyen_trach,
									'du_hoc' => $info->du_hoc,
									'quoc_gia' => $info->quoc_gia,
									'ghi_chu' => $info->ghi_chu,
									'active' => $info->active,
									'active_text' => $info->active?'Xảy ra':'Ẩn',
									'chuc_vu_active' => $info->chuc_vu_active
							];
					}
				} catch (HandlerMsgCommon $e) {
						throw $e->render();
				}
				
				$json = [
						'data' => [
								'results' => $results,
						]
				];
				return $this->respondWithCollectionPagination($json);
		}

		public function listLinhMucBoNhiem($infoId = null, LinhmucRequest $request) 
		{
				try {
					$collections = $this->linhMucSv->apiGetBoNhiem($infoId);
					$results = [];

					foreach ($collections as $key => $info) {
							$results[] = [
									'id' => (int)$info->id,
									'isCheck' => false,
                  'isEdit' => 1,					
									'to_date' => $info->to_date,
									'from_date' => $info->from_date,
									'chuc_vu_id' => $info->chuc_vu_id,
									'chucvuName' => $info->ten_to_chuc_vu,
									'label_from_date' => ($info->from_date)?date_format(date_create($info->from_date),"Y-m-d"):'',
									'label_to_date' => ($info->to_date)?date_format(date_create($info->to_date),"Y-m-d"):'',
									'ghi_chu' => $info->ghi_chu,
									'active' => $info->active,
									'active_text' => $info->active?'Xảy ra':'Ẩn',
									'chuc_vu_active' => $info->chuc_vu_active,
							];
					}
				} catch (HandlerMsgCommon $e) {
						throw $e->render();
				}
				
				$json = [
						'data' => [
								'results' => $results,
						]
				];
				return $this->respondWithCollectionPagination($json);
		}
}
