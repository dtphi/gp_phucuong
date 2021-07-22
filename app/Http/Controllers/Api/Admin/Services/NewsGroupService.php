<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\NewsGroupModel;
use App\Http\Resources\NewsGroups\NewsGroupCollection;
use App\Http\Resources\NewsGroups\NewsGroupResource;
use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\CategoryPath;
use App\Models\CategoryToLayout;
use App\Models\InformationToCategory;
use App\Models\NewsGroup;
use DB;
use Illuminate\Support\Str;

final class NewsGroupService implements BaseModel, NewsGroupModel
{
    /**
     * @var Admin|null
     */
    private $model = null;

    /**
     * @var CategoryDescription|null
     */
    private $modelDes = null;

    /**
     * @var CategoryPath|null
     */
    private $modelPath = null;

    private $separate = ' >> ';

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model     = new Category();
        $this->modelDes  = new CategoryDescription();
        $this->modelPath = new CategoryPath();
    }

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetList(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetNewsGroupTrees($options, $limit);

        return $query->paginate($limit);
    }

    /**
     * author : dtphi .
     * @param array $options
     * @param int $limit
     * @return NewsGroupCollection
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetResourceCollection() method.
        $paginations = $this->apiGetList($options, $limit);

        return new NewsGroupCollection($paginations->getCollection());
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return NewsGroup|null
     */
    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
        $query = DB::table(Tables::$categorys . ' AS c')->select('*', 'c.category_id AS category_id', DB::raw("(
                    SELECT
                        GROUP_CONCAT(
                            cd1.`name`
                            ORDER BY
                                `level` SEPARATOR '" . $this->separate . "'
                        )
                    FROM
                        " . Tables::$category_paths . " cp
                    LEFT JOIN " . Tables::$category_descriptions . " cd1 ON (
                        cp.path_id = cd1.category_id
                        AND cp.category_id != cp.path_id
                    )
                    WHERE
                        cp.category_id = c.category_id
                    GROUP BY
                        cp.category_id
                ) AS path"))
            ->distinct()
            ->leftJoin(Tables::$category_descriptions . ' AS cd2', 'c.category_id', '=', 'cd2.category_id')
            ->leftJoin(Tables::$category_to_layouts . ' AS ctl', 'c.category_id', '=', 'ctl.category_id')
            ->where('c.category_id', $id);

        return $query->first();
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return NewsGroupResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.

        return new NewsGroupResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     */
    public function apiInsertOrUpdate(array $data = [])
    {
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return Admin|bool|null
     */
    public function apiInsert(array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.
        $this->model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        try {
            if ($this->model->save()) {
                $data['category_id'] = $this->model->category_id;

                $this->model->name_slug = Str::slug($data['name'] . ' ' . $data['category_id']);
                $this->model->save();


                CategoryDescription::insertByCateId($data['category_id'], $data['name'], $data['description'],
                    $data['meta_title'], $data['meta_description'], $data['meta_keyword']);

                /*MySQL Hierarchical Data Closure Table Pattern*/
                $level       = 0;
                $resultPaths = $this->modelPath->where('category_id', $data['parent_id'])
                    ->orderBy('level', 'ASC')->get();

                foreach ($resultPaths as $key => $resultPath) {
                    CategoryPath::insertByCateId($data['category_id'], $resultPath['path_id'], $level);

                    $level++;
                }
                CategoryPath::insertByCateId($data['category_id'], $data['category_id'], $level);

                if (isset($data['layout_id'])) {
                    CategoryToLayout::insertByCateId($data['category_id'], $data['layout_id']);
                }

            } else {
                DB::rollBack();

                return false;
            }

        } catch (\Exceptions $e) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param null $categoryId
     * @return mixed
     */
    public function getCateogryById($categoryId = null)
    {
        if ($categoryId) {
            return $this->model->findOrFail($categoryId);
        }
    }

    /**
     * @author : dtphi .
     * @param null $categoryId
     * @return mixed
     */
    public function getCategoryDesById($categoryId = null)
    {
        if ($categoryId) {
            return $this->modelDes->findOrFail($categoryId);
        }
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return Admin|bool|null
     */
    public function apiUpdate($model, array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.
        $data['name_slug'] = Str::slug($data['name'] . ' ' . $model->category_id);

        $model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        try {
            if ($model->save()) {
                $categoryId = $model->category_id;

                $modelDes = $model->description;
                $dataDes  = [
                    'name'             => $data['name'],
                    'description'      => $data['description'],
                    'meta_title'       => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                    'meta_keyword'     => $data['meta_keyword']
                ];

                if ($dataDes) {
                    $modelDes->fill($dataDes);
                    $modelDes->save();
                } else {
                    CategoryDescription::insertByCateId($categoryId, $data['name'], $data['description'],
                        $data['meta_title'], $data['meta_description'], $data['meta_keyword']);
                }

                /*MySQL Hierarchical Data Closure Table Pattern*/
                $resultPaths = $this->modelPath->where('path_id', (int)$categoryId)
                    ->orderBy('level', 'ASC')->get();

                if ($resultPaths->count()) {
                    foreach ($resultPaths as $key => $resultPath) {
                        CategoryPath::fcDeleteByCateIdAndLevelDown($resultPath['category_id'], $resultPath['level']);

                        $path = [];

                        $resultPathCurParents = $this->modelPath->where('category_id', (int)$data['parent_id'])
                            ->orderBy('level', 'ASC')->get();

                        foreach ($resultPathCurParents as $resultPathCurParent) {
                            $path[] = $resultPathCurParent['path_id'];
                        }

                        $resultPathLefts = $this->modelPath->where('category_id', (int)$resultPath['category_id'])
                            ->orderBy('level', 'ASC')->get();

                        foreach ($resultPathLefts as $resultPathLeft) {
                            $path[] = $resultPathLeft['path_id'];
                        }

                        // Combine the paths with a new level
                        $level = 0;
                        foreach ($path as $path_id) {
                            CategoryPath::replaceByCateidAndPathAndLevel($resultPath['category_id'], $path_id, $level);

                            $level++;
                        }
                    }
                } else {
                    // Delete the path below the current one
                    CategoryPath::fcDeleteByCateId($categoryId);

                    // Fix for records with no paths
                    $level = 0;

                    $resultPathParents = $this->modelPath->where('category_id',
                        (int)$data['parent_id'])->orderBy('level', 'ASC')->get();

                    foreach ($resultPathParents as $resultPathParent) {
                        CategoryPath::insertByCateId($categoryId, $resultPathParent['path_id'], $level);

                        $level++;
                    }

                    CategoryPath::replaceByCateidAndPathAndLevel($categoryId, $categoryId, $level);
                }

                CategoryToLayout::fcDeleteByCateId($categoryId);
                if (isset($data['layout_id'])) {
                    CategoryToLayout::insertByCateId($categoryId, $data['layout_id']);
                }

            } else {
                DB::rollBack();

                return false;
            }

        } catch (\Exceptions $e) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return mixed
     */
    public function apiGetNewsGroupTrees($data = array())
    {
        $cate1    = 'cate1';
        $cate2    = 'cate2';
        $cateDes1 = 'cd1';
        $cateDes2 = 'cd2';

        $query = $this->modelPath
            ->select(Tables::$category_paths . '.category_id AS category_id', $cate1 . '.parent_id',
                $cate1 . '.sort_order', CategoryPath::getRawCategoryName($cateDes1, 'category_name'))
            ->gbByCategoryId()
            ->ljoinCategory($cate1)
            ->ljoinCategory($cate2)
            ->ljoinCateDescription($cateDes1)
            ->ljoinCateDescription($cateDes2);

        if (!empty($data['filter_name'])) {
            $query->filterLikeName($cateDes2, $data['filter_name']);
        }

        $sort_data = array(
            'name',
            'sort_order'
        );

        $sqlSort = '';
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sqlSort .= $cate1 . '.' . $data['sort'];
        } else {
            $sqlSort .= $cate1 . '.sort_order';
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $query->orderBy($sqlSort, 'DESC');
        } else {
            $query->orderBy($sqlSort, 'ASC');
        }

        /*if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }*/

        //dd($query->toSql());
        return $query;
    }

    /**
     * @author : dtphi.
     * @param $cateId
     */
    private function _deleteById($cateId)
    {
        if ($cateId) {
            CategoryPath::fcDeleteByCateId($cateId);

            $resultPaths = $this->modelPath->where('path_id', '=', (int)$cateId)->get();
            foreach ($resultPaths as $resultPath) {
                $this->_deleteById($resultPath->category_id);
            }

            Category::fcDeleteByCateId($cateId);
            CategoryDescription::fcDeleteByCateId($cateId);
            CategoryToLayout::fcDeleteByCateId($cateId);
            InformationToCategory::fcDeleteByCateId($cateId);
        }
    }

    /**
     * @author : dtphi.
     * @param $model
     * @return bool
     */
    public function deleteCategory($model)
    {
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        try {
            $cateId = $model->category_id;

            $this->_deleteById($cateId);

        } catch (\Exceptions $e) {
            DB::rollBack();

            return false;
        }

        DB::commit();
    }

    public function apiGetCategories($data = array(), $limit = 15)
    {
        $cate1 = 'cate1';
        $cate2 = 'cate2';
        $cd1   = 'cd1';
        $cd2   = 'cd2';

        $query = $this->modelPath
            ->select(Tables::$category_paths . '.category_id AS category_id', $cate1 . '.parent_id',
                $cate1 . '.sort_order', CategoryPath::getRawCategoryName($cd1))
            ->gbByCategoryId()
            ->ljoinCategory($cate1)
            ->ljoinCategory($cate2)
            ->ljoinCateDescription($cd1)
            ->ljoinCateDescription($cd2);

        if (!empty($data['filter_name'])) {
            $query->filterLikeName($cd2, $data['filter_name']);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function importCategory()
    {
        $data    = [];
        $results = DB::table('news_groups')->get();

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        try {
            foreach ($results as $group) {
                Category::insertForce($group->id, $group->father_id);
                $categoryId = $group->id;

                CategoryDescription::insertByCateId($group->id, $group->newsgroupname, '',
                    $group->newsgroupnamenomark, '', '');

                /*MySQL Hierarchical Data Closure Table Pattern*/
                $level       = 0;
                $resultPaths = $this->modelPath->where('category_id', $group->father_id)
                    ->orderBy('level', 'ASC')->get();

                foreach ($resultPaths as $key => $resultPath) {
                    CategoryPath::insertByCateId($group->id, $resultPath['path_id'], $level);

                    $level++;
                }
                CategoryPath::insertByCateId($group->id, $group->id, $level);
            }
        } catch (\Exceptions $e) {
            DB::rollBack();

            return false;
        }

        DB::commit();

    }

    public function connectSqlServer()
    {
        $servername = "103.139.202.9";
        $username   = "giaophanphucuong_db";
        $password   = "xY8uKdxKazxBguiV82gQ";
        $database   = "giaophanphucuong_db";
        $port       = "1433";
        try {
            $conn = new \PDO("sqlsrv:server=103.139.202.9:1433;Database=giaophanphucuong_db;ConnectionPooling=0",
                "giaophanphucuong_db", "xY8uKdxKazxBguiV82gQ",
                array(
                    \PDO::ATTR_PERSISTENT => true,
                    \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (\PDOException $e) {
            echo("Error connecting to SQL Server: " . $e->getMessage());
        }

        if (isset($conn)) {
            $sql = "SELECT * FROM NewsGroup";

            foreach ($conn->query($sql) as $row) {
                dd($row);
            }
        }
    }

}
