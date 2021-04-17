<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\InformationModel;
use App\Http\Resources\Informations\InformationCollection;
use App\Http\Resources\Informations\InformationResource;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\InformationImage;
use App\Models\InformationRelated;
use App\Models\InformationToCategory;
use App\Models\InformationToDownload;
use DB;

final class InformationService implements BaseModel, InformationModel
{
    /**
     * @var Information|null
     */
    private $model = null;

    /**
     * @var InformationDescription|null
     */
    private $modelDes = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new Information();
        $this->modelDes = new InformationDescription();
    }

    /**
     * @author: dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetInformations($options, $limit);

        return $query->paginate($limit);
    }

    /**
     * author : dtphi .
     * @param array $options
     * @param int $limit
     * @return InformationCollection
     */
    public function apiGetResourceCollection(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return new InformationCollection($this->apiGetList($options, $limit));
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return AdminResource
     */
    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
        $this->model = $this->model->findOrFail($id);

        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return InformationResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new InformationResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return Admin|bool|null
     */
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

    /**
     * @author : dtphi .
     * @param array $data
     * @return Admin|Information|bool|null
     */
    public function apiInsert($data = [])
    {
        $this->model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if ($this->model->save()) {
            $infoId = $this->model->information_id;

            if (isset($data['image_path'])) {
                $this->model->image = $data['image_path'];
                $this->model->save();
            }

            InformationDescription::insertByInfoId($infoId, fn_mysql_escape($data['name']), fn_mysql_escape($data['description']), $data['tag'],
                $data['meta_title'], $data['meta_description'], $data['meta_keyword']);

            if (isset($data['info_images']) && !empty($data['info_images'])) {
                foreach ($data['info_images'] as $information_image) {
                    InformationImage::insertByInfoId($infoId, $information_image['image'],
                        $information_image['sort_order']);
                }
            }

            if (isset($data['downloads']) && !empty($data['downloads'])) {
                foreach ($data['downloads'] as $downloadId) {
                    InformationToDownload::insertByInfoId($infoId, $downloadId);
                }
            }

            if (isset($data['categorys']) && !empty($data['categorys'])) {
                foreach ($data['categorys'] as $categoryId) {
                    InformationToCategory::insertByInfoId($infoId, $categoryId);
                }
            }

            if (isset($data['relateds']) && !empty($data['relateds'])) {
                foreach ($data['relateds'] as $relatedId) {
                    InformationRelated::fcDeleteByInfoAndRelatedId($infoId, $relatedId);
                    InformationRelated::insertByInfoId($infoId, $relatedId);
                    InformationRelated::fcDeleteByInfoAndRelatedId($relatedId, $infoId);
                    InformationRelated::insertByInfoId($relatedId, $infoId);
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

    /**
     * @author : dtphi .
     * @param $model
     * @param array $data
     * @return Admin|Information|bool|null
     */
    public function apiUpdate($model, $data = [])
    {
        $model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if ($model->save()) {
            $infoId = $model->information_id;

            if (isset($data['image_path'])) {
                $model->image = $data['image_path'];
                $model->save();
            }

            $modelDes = $model->infoDes;
            if ($modelDes) {
                $dataDes = [
                    'name'             => fn_mysql_escape($data['name']),
                    'tag'              => $data['tag'],
                    'description'      => fn_mysql_escape($data['description']),
                    'meta_title'       => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                    'meta_keyword'     => $data['meta_keyword']
                ];

                $modelDes->fill($dataDes);
                $modelDes->save();
            }

            InformationImage::fcDeleteByInfoId($infoId);
            if (isset($data['info_images']) && !empty($data['info_images'])) {
                foreach ($data['info_images'] as $information_image) {
                    InformationImage::insertByInfoId($infoId, $information_image['image'],
                        $information_image['sort_order']);
                }
            }

            InformationToDownload::fcDeleteByInfoId($infoId);
            if (isset($data['downloads']) && !empty($data['downloads'])) {
                foreach ($data['downloads'] as $downloadId) {
                    InformationToDownload::insertByInfoId($infoId, $downloadId);
                }
            }

            InformationToCategory::fcDeleteByInfoId($infoId);
            if (isset($data['categorys']) && !empty($data['categorys'])) {
                foreach ($data['categorys'] as $categoryId) {
                    InformationToCategory::insertByInfoId($infoId, $categoryId);
                }
            }

            InformationRelated::fcDeleteByInfoId($infoId);
            InformationRelated::fcDeleteByRelatedId($infoId);
            if (isset($data['relateds']) && !empty($data['relateds'])) {
                foreach ($data['relateds'] as $relatedId) {
                    InformationRelated::fcDeleteByInfoAndRelatedId($infoId, $relatedId);
                    InformationRelated::insertByInfoId($infoId, $relatedId);
                    InformationRelated::fcDeleteByInfoAndRelatedId($relatedId, $infoId);
                    InformationRelated::insertByInfoId($relatedId, $infoId);
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
     * @param array $data
     * @param int $limit
     * @return mixed
     */
    public function apiGetBuilderInformations($data = [], $limit = 5)
    {
        $alias = 'infoDes';

        $query = DB::table(Tables::$informations)->leftJoin(Tables::$information_descriptions . ' AS ' . $alias,
            Tables::$informations . '.information_id', '=', $alias . '.information_id')->limit($limit);

        return $query;
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @param int $limit
     * @return mixed
     */
    public function apiGetInformations($data = array(), $limit = 5)
    {
        $query = $this->model->select()->limit($limit);

        return $query;
    }

    /**
     * @author : dtphi .
     * @param null $model
     */
    public function deleteInformation($model = null)
    {
        if ($model instanceof Information) {
            $infoId = $model->information_id;

            $model->delete();
            $modelDes = $this->modelDes->where('information_id', $infoId)->first();
            if ($modelDes instanceof InformationDescription) {
                $modelDes->delete();
            }

            InformationImage::fcDeleteByInfoId($infoId);
            InformationToCategory::fcDeleteByInfoId($infoId);
            InformationToDownload::fcDeleteByInfoId($infoId);
            InformationRelated::fcDeleteByInfoId($infoId);
            InformationRelated::fcDeleteByRelatedId($infoId);

        }
    }
}
