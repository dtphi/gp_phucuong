<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanTinTucModel;
use App\Http\Resources\GiaoPhanTinTucs\GiaoPhanTinTucCollection;
use App\Http\Resources\GiaoPhanTinTucs\GiaoPhanTinTucResource;
use App\Models\GiaoPhanTinTuc;
use App\Models\GiaoPhanTinTucMoTa;
use App\Models\GiaoPhanTinTucDanhMuc;
use DB;
use Illuminate\Support\Str;

final class GiaoPhanTinTucService implements BaseModel, GiaoPhanTinTucModel
{
  /**
   * @var GiaoPhanTinTuc|null
   */
  private $model = null;

  /**
   * @var GiaoPhanTinTucMoTa|null
   */
  private $modelDes = null;

  /**
   * @author : dtphi .
   * AdminService constructor.
   */
  public function __construct()
  {
    $this->model    = new GiaoPhanTinTuc();
    $this->modelDes = new GiaoPhanTinTucMoTa();
  }

  // admin source
  public function apiGetList(array $options = [], $limit = 5)
  {
    // TODO: Implement apiGetList() method.
    $query = $this->apiGetInformations($options);

    if (isset($options['infoType']) && $options['infoType'] == 'module_special_info') {
      return $query->get();
    }

    return $query->paginate($limit);
  }

  // giaophantintuc collection
  public function apiGetResourceCollection(array $options = [], $limit = 5)
  {
    // TODO: Implement apiGetResourceCollection() method.
    return new GiaoPhanTinTucCollection($this->apiGetList($options, $limit));
  }

  // admin resource
  public function apiGetDetail($id = null)
  {
    // TODO: Implement apiGetDetail() method.
    $this->model = $this->model->findOrFail($id);

    return $this->model;
  }

  // giaophantintuc resource
  public function apiGetResourceDetail($id = null)
  {
    // TODO: Implement apiGetResourceDetail() method.
    return new GiaoPhanTinTucResource($this->apiGetDetail($id));
  }

  
  public function apiInsertOrUpdate(array $data = [])
  {
    // TODO: Implement apiInsertOrUpdate() method.
    $this->model->fill($data);

    /**
     * Save user with transaction to make sure all data stored correctly
     */
    DB::beginTransaction();

    if (!$this->model->save()) {
      DB::rollBack();

      return false;
    }

    DB::commit();

    return $this->model;
  }

  
  public function apiInsert($data = [])
  {
    
    /**
     * Save user with transaction to make sure all data stored correctly
     */
    DB::beginTransaction();
    $this->model->fill($data);
    if ($this->model->save()) {
      $infoId = $this->model->information_id;

      if (isset($data['image_path'])) {
        $this->model->image       = $data['image_path'];
        $this->model->image_thumb = $data['image_thumb'];
      }
      $this->model->name_slug = Str::slug($data['name'] . ' ' . $infoId);
      $this->model->save();

      GiaoPhanTinTucMoTa::insertByInfoId(
        $infoId,
        $data['name'],
        htmlentities($data['description']),
        $data['tag'],
        $data['meta_title'],
        $data['meta_description'],
        $data['meta_keyword']
      );


      if (isset($data['categorys']) && !empty($data['categorys'])) {
        foreach ($data['categorys'] as $categoryId) {
          GiaoPhanTinTucDanhMuc::insertByInfoId($infoId, $categoryId);
        }
      }
    } else {
      DB::rollBack();

      return false;
    }

    DB::commit();

    return $this->model;
  }

  /**
   * @author : dtphi .
   * @param null $infoId
   * @return mixed
   */
  public function getInfoDesById($infoId = null)
  {
    if ($infoId) {
      return $this->modelDes->findOrFail($infoId);
    }
  }

 
  public function apiUpdate($model, $data = [])
  {
    /**
     * Save user with transaction to make sure all data stored correctly
     */
    DB::beginTransaction();

    $model->fill($data);

    if ($model->save()) {
      $infoId = $model->information_id;

      if (isset($data['image_path'])) {
        $model->image       = $data['image_path'];
        $model->image_thumb = $data['image_thumb'];
        $model->save();
      }
      $model->name_slug = Str::slug($model->name . ' ' . $infoId);
      $model->save();

      $modelDes = $model->infoDes;
      if ($modelDes) {
        $dataDes = [
          'name'             => $data['name'],
          'tag'              => $data['tag'],
          'description'      => htmlentities($data['description']),
          'meta_title'       => $data['meta_title'],
          'meta_description' => $data['meta_description'],
          'meta_keyword'     => $data['meta_keyword']
        ];

        $modelDes->fill($dataDes);
        $modelDes->save();
      }


      GiaoPhanTinTucDanhMuc::fcDeleteByInfoId($infoId);
      if (isset($data['categorys']) && !empty($data['categorys'])) {
        foreach ($data['categorys'] as $categoryId) {
          GiaoPhanTinTucDanhMuc::insertByInfoId($infoId, $categoryId);
        }
      }
    } else {
      DB::rollBack();

      return false;
    }

    DB::commit();

    return $this->model;
  }

  public function apiGetBuilderInformations($data = [], $limit = 5)
  {
    $alias = 'infoDes';

    $query = DB::table(Tables::$giaophantintucs)->leftJoin(
      Tables::$giaophantintuc_motas . ' AS ' . $alias,
      Tables::$giaophantintucs . '.information_id',
      '=',
      $alias . '.information_id'
    )->limit($limit);

    return $query;
  }


  public function apiGetInformations($data = array(), $limit = 5)
  {
    if (isset($data['infoIds']) && isset($data['infoType']) && $data['infoType'] == 'module_special_info') {
      $infoIds = [];
      foreach ($data['infoIds'] as $info) {
        $infoSlide = json_decode($info);
        if (isset($infoSlide->id)) {
          $infoIds[] = (int)$infoSlide->id;
        }
      }

      $query = $this->model->select()
        ->whereIn('information_id', $infoIds)
        ->orderBy('sort_order', 'DESC')
        ->orderBy('date_available', 'DESC');
    } else {
      $query = $this->model->select()
        ->orderBy('information_id', 'DESC');
    }

    return $query;
  }

  /**
   * @author : dtphi .
   * @param null $model
   */
  public function deleteInformation($model = null)
  {
		$infoId = $model->information_id;

		if($infoId) {
			GiaoPhanTinTuc::fcDeleteByInfoId($infoId);
			GiaoPhanTinTucMoTa::fcDeleteByInfoId($infoId);
			GiaoPhanTinTucDanhMuc::fcDeleteByInfoId($infoId);
		}
		
    /* if ($model instanceof GiaoPhanTinTuc) {
      $infoId = $model->information_id;
      $model->delete();
      $modelDes = $this->modelDes->where('information_id', $infoId)->first();
      if ($modelDes instanceof GiaoPhanTinTucMoTa) {
        $modelDes->delete();
      }
      GiaoPhanTinTucDanhMuc::fcDeleteByInfoId($infoId);
    } */
  }

  public function importInformation()
  {
    $data    = [];
    $results = DB::table('newss_groups')->get();

    DB::beginTransaction();

    foreach ($results as $info) {
      $infoId   = $info->id;
      $sortDes  = $info->description;
      
      $nameSlug = Str::slug($info->name . ' ' . $infoId);
      GiaoPhanTinTuc::insertForce(
        $info->id,
        $info->picture,
        0,
        1,
        $info->sort,
        $info->context1,
        $info->description,
        $nameSlug
      );

      $des = htmlentities($info->context);

      GiaoPhanTinTucMoTa::insertByInfoId(
        $infoId,
        $info->newsgroupname,
        $des,
        $info->tag,
        $info->metatitle,
        $info->metadescription,
        $info->metakeyword
      );

      GiaoPhanTinTucDanhMuc::insertByInfoId($infoId, $info->father_id);
    }

    DB::commit();
  }
}
