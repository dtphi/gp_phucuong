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
use App\Models\InformationCarousel;
use App\Models\Albums;
use App\Models\Tag;
use DB;
use Illuminate\Support\Str;
use Auth;
use yii\debug\models\search\Log;

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

    private $modelAlbum = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new Information();
        $this->modelDes = new InformationDescription();
        $this->modelAlbum = new Albums();
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
        $query = $this->apiGetInformations($options);

        if (isset($options['infoType']) && $options['infoType'] == 'module_special_info') {
            return $query->get();
        }

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
            $data['tag'] = $this->_getTagIds($data['tag']);
            InformationDescription::insertByInfoId($infoId, $data['name'], htmlentities($data['description']),
                $data['tag'],
                $data['meta_title'], $data['meta_description'], $data['meta_keyword']);

            if (isset($data['info_images']) && !empty($data['info_images'])) {
                foreach ($data['info_images'] as $information_image) {
                    InformationImage::insertByInfoId($infoId, $information_image['image'],
                        $information_image['sort_order']);
                }
            }

            if (isset($data['album'])) {
                InformationImage::insertAlbumByInfoId($infoId, $data['album']);
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

            if (isset($data['special_carousels']) && !empty($data['special_carousels'])) {
                $carouselData = [
                    'name' => $data['name'],
                    'name_slug' => $this->model->name_slug,
                    'sort_description' => $data['sort_description'],
                    'description' => htmlentities($data['description']),
                    'image_origin' => $this->model->image['path'],
                    'image' => serialize($data['special_carousels']['value']),
                    'sort_order' => $data['sort_order'],
                    'date_available' => $data['date_available'],
                    'information_type' => $data['info_type'],
                    'viewed' => 0,
                    'vote' => 0
                ];
                InformationCarousel::insertByInfoId($infoId, $carouselData);
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    private function _getTagIds($tag = '') 
    {
        $tagIds = [];
        if (!empty($tag)) {
            $arrTags = explode(',', $tag);
            foreach ($arrTags as $tag) {
                $tagSlug = Str::slug($tag);
                $model = Tag::updateOrCreate(
                    ['name_slug' => $tagSlug],
                    [
                        'name' => $tag, 
                        'update_user' => Auth::user()->id
                    ]
                );
                if ($model) {
                    $tagIds[] = $model->id;
                }
            }
        }

        return implode('|',$tagIds);
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

            $data['tag'] = $this->_getTagIds($data['tag']);
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

            InformationImage::fcDeleteByInfoId($infoId);
            if (isset($data['info_images']) && !empty($data['info_images'])) {
                foreach ($data['info_images'] as $information_image) {
                    InformationImage::insertByInfoId($infoId, $information_image['image'],
                        $information_image['sort_order']);
                }
            }

            if (isset($data['album'])) {
                InformationImage::insertAlbumByInfoId($infoId, $data['album']);
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

            $modelCarousel = $model->infoCarousel;
            $dataCarousel = [
                'name' => $data['name'],
                'name_slug' => $this->model->name_slug,
                'sort_description' => $data['sort_description'],
                'description' => htmlentities($data['description']),
                'image_origin' => $this->model->image['path'],
                'image' => serialize($data['special_carousels']['value']),
                'sort_order' => $data['sort_order'],
                'date_available' => $data['date_available'],
                'information_type' => $data['info_type'],
                'viewed' => $this->model->viewed,
                'vote' => $this->model->vote
            ];
            if ($modelCarousel) {
                $modelCarousel->fill($dataCarousel);
                $modelCarousel->save();
            } else {
                InformationCarousel::insertByInfoId($infoId, $dataCarousel);
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
        if (isset($data['infoIds']) && isset($data['infoType']) && $data['infoType'] == 'module_special_info') {
            $infoIds = [];

            if (is_array($data['infoIds']) && !empty($data['infoIds'])) {
                foreach ($data['infoIds'] as $info) {
                    $infoSlide = json_decode($info);
                    if (isset($infoSlide->id)) {
                        $infoIds[] = (int)$infoSlide->id;
                    }
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

    public function apiGetAlbumList($data = array())
    {
        $query = $this->modelAlbum->select()
                ->where('status', 1)
                ->orderByDesc('updated_at', 'DESC');

        return $query->get();
    }

    /**
     * @author : dtphi .
     * @param null $model
     */
    public function deleteInformation($model = null)
    {
			$infoId = $model->information_id;

			if ($infoId) {
				Information::fcDeleteByInfoId($infoId);
				InformationDescription::fcDeleteByInfoId($infoId);
				InformationToCategory::fcDeleteByInfoId($infoId);
				InformationToDownload::fcDeleteByInfoId($infoId);
				InformationRelated::fcDeleteByInfoId($infoId);
				InformationRelated::fcDeleteByRelatedId($infoId);
			}
        /* if ($model instanceof Information) {
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
            $nameSlug = Str::slug($name . ' ' . $infoId);
            Information::insertForce($info->id, $info->picture, 0, 1, $info->sort, $info->context1, $info->description,
                $nameSlug);

            $des = htmlentities($info->context);

            InformationDescription::insertByInfoId($infoId, $info->newsgroupname, $des, $info->tag,
                $info->metatitle, $info->metadescription, $info->metakeyword);

            InformationToCategory::insertByInfoId($infoId, $info->father_id);
        }

        DB::commit();
    }
}
