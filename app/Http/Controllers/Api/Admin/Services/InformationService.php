<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\InformationModel;
use App\Http\Resources\Informations\InformationCollection;
use App\Http\Resources\Informations\InformationResource;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\InformationImage;
use App\Models\InformationToCategory;
use App\Models\InformationToDownload;
use App\Http\Common\Tables;
use DB;

final class InformationService implements BaseModel, InformationModel
{
    /**
     * @var Admin|null
     */
    private $model = null;

    private $modelDes = null;

    private $modelImg = null;

    private $modelCate = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new Information();
        $this->modelDes = new InformationDescription();
        $this->modelCate = new InformationToCategory();
        $this->modelImg = new InformationImage();
    }

    /**
     * @author: dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetList(array $options = [], $limit = 15)
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
    public function apiGetResourceCollection(array $options = [], $limit = 15)
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

            InformationDescription::insertByInfoId($infoId, $data['name'], $data['description'], $data['tag'], $data['meta_title'], $data['meta_description'], $data['meta_keyword']);

            if (isset($data['info_images']) && !empty($data['info_images'])) {
                foreach ($data['info_images'] as $information_image) {
                    InformationImage::insertByInfoId($infoId, $information_image['image'], $information_image['sort_order']);
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

            if (isset($data['image'])) {
                $model->image = $data['image'];
                $model->save();
            }

            $modelDes = $this->getInfoDesById((int)$infoId);
            $modelDes->fill($data);
            $modelDes->save();

            DB::delete("delete from " . Tables::$information_images . " where information_id = '" . (int)$infoId . "'");
            if (isset($data['info_images']) && !empty($data['info_images'])) {
                foreach ($data['info_images'] as $information_image) {
                    DB::insert('insert into ' . Tables::$information_images . ' (information_id, image, sort_order) values (?, ?, ?)', [
                        (int)$infoId,
                        $information_image['image'],
                        (int)$information_image['sort_order']
                    ]);
                }
            }

            DB::delete("delete from " . Tables::$information_to_downloads . " where information_id = '" . (int)$infoId . "'");
            if (isset($data['downloads']) && !empty($data['downloads'])) {
                foreach ($data['downloads'] as $downloadId) {
                    DB::insert('insert into ' . Tables::$information_to_downloads . ' (information_id, download_id) values (?, ?)', [
                        (int)$infoId,
                        (int)$downloadId
                    ]);
                }
            }

            DB::delete("delete from " . Tables::$information_to_categorys . " where information_id = '" . (int)$infoId . "'");
            if (isset($data['categorys']) && !empty($data['categorys'])) {
                foreach ($data['categorys'] as $categoryId) {
                    DB::insert('insert into ' . Tables::$information_to_categorys . ' (information_id, category_id) values (?, ?)', [
                        (int)$infoId,
                        (int)$categoryId
                    ]);
                }
            }

            DB::delete("delete from " . Tables::$information_relateds . " where information_id = '" . (int)$infoId . "'");
            DB::delete("delete from " . Tables::$information_relateds . " WHERE related_id = '" . (int)$infoId . "'");
            if (isset($data['relateds']) && !empty($data['relateds'])) {
                foreach ($data['relateds'] as $relatedId) {
                    DB::delete("delete from " . Tables::$information_relateds . " where information_id = '" . (int)$infoId . "' and related_id = '" . (int)$relatedId . "'");
                    DB::insert("insert into " . Tables::$information_relateds . " set information_id = '" . (int)$infoId . "', related_id = '" . (int)$relatedId . "'");
                    DB::delete("delete from " . Tables::$information_relateds . " where information_id = '" . (int)$relatedId . "' and related_id = '" . (int)$infoId . "'");

                    DB::insert("insert into " . Tables::$information_relateds . " set information_id = '" . (int)$relatedId . "', related_id = '" . (int)$infoId . "'");
                }
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    public function apiGetInformations($data = array(), $limit = 5) {
        $query = $this->model->select()
        ->ljoinDescription()->limit($limit);

        return $query;
        /*$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND nd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== '') {
            $sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
        }

        $sql .= " GROUP BY n.news_id";

        $sort_data = array(
            'nd.name',
            'n.status',
            'n.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY nd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;*/
    }
}
