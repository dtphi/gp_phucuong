<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;
use App\Http\Common\Tables;
use Illuminate\Support\Str;
use App\Models\GiaoPhanDanhMuc;
use App\Models\GiaoPhanDanhMucMoTa;
use App\Models\GiaoPhanTinTucDanhMuc;
use App\Models\GiaoPhanDanhMucLienKet;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Resources\GiaoPhanDanhMucs\GiaoPhanDanhMucResource;
use App\Http\Resources\GiaoPhanDanhMucs\GiaoPhanDanhMucCollection;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanDanhMucModel;

final class GiaoPhanDanhMucService implements BaseModel, GiaoPhanDanhMucModel
{
	/**
	 * @var Admin|null
	 */
	private $model = null;

	//* GiaoPhanDanhMucMoTa | null
	private $modelDes = null;

	//* GiaoPhanDanhMucLienKet | null
	private $modelPath = null;

	private $separate = ' >> ';

	public function __construct()
	{
		$this->model     = new GiaoPhanDanhMuc();
		$this->modelDes  = new GiaoPhanDanhMucMoTa();
		$this->modelPath = new GiaoPhanDanhMucLienKet();
	}

	public function apiGetDetail($id = null)
	{
		// TODO: Implement apiGetDetail() method.
		$query = DB::table(Tables::$giaophandanhmucs . ' AS c')->select('*', 'c.category_id AS category_id', DB::raw("(
                    SELECT
                        GROUP_CONCAT(
                            cd1.`name`
                            ORDER BY
                                `level` SEPARATOR '" . $this->separate . "'
                        )
                    FROM
                        " . Tables::$giaophandanhmuc_lienkets . " cp
                    LEFT JOIN " . Tables::$giaophandanhmuc_motas . " cd1 ON (
                        cp.path_id = cd1.category_id
                        AND cp.category_id != cp.path_id
                    )
                    WHERE
                        cp.category_id = c.category_id
                    GROUP BY
                        cp.category_id
                ) AS path"))
			->distinct()
			->leftJoin(Tables::$giaophandanhmuc_motas . ' AS cd2', 'c.category_id', '=', 'cd2.category_id')
			->where('c.category_id', $id);

		return $query->first();
	}

	public function apiGetResourceDetail($id = null)
	{
		// TODO: Implement apiGetResourceDetail() method.

		return new GiaoPhanDanhMucResource($this->apiGetDetail($id));
	}

	/**
	 * @author : dtphi .
	 * @param array $data
	 * @return mixed
	 */
	public function apiInsertOrUpdate(array $data = [])
	{
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
		$query = $this->apiGetGiaoPhanDanhMucTrees($options, $limit);

		return $query->paginate($limit);
	}

	/**
	 * author : dtphi .
	 * @param array $options
	 * @param int $limit
	 * @return GiaoPhanDanhMucCollection
	 */
	public function apiGetResourceCollection(array $options = [], $limit = 15)
	{
		// TODO: Implement apiGetResourceCollection() method.
		$paginations = $this->apiGetList($options, $limit);

		return new GiaoPhanDanhMucCollection($paginations->getCollection());
	}

	/**
	 * @author : dtphi .
	 * @param array $data
	 * @return mixed
	 */
	public function apiGetGiaoPhanDanhMucTrees($data = array())
	{
		$cate1    = 'cate1';
		$des1 = 'cd1';

		$query = $this->modelPath->select(
			Tables::$giaophandanhmuc_lienkets . '.category_id AS category_id',
			$cate1 . '.parent_id',
			$cate1 . '.sort_order',
			GiaoPhanDanhMucLienKet::getRawCategoryName($des1, 'category_name')
		)
			->gbByCategoryId()
			->ljoinCategory($cate1)
			->ljoinCategoryDescription($des1);

		if (!empty($data['filter_name'])) {
			$query->filterLikeName($des1, $data['filter_name']);
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
		return $query;
	}

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


				GiaoPhanDanhMucMoTa::insertByCateId(
					$data['category_id'],
					$data['name'],
					$data['description'],
					$data['meta_title'],
					$data['meta_description'],
					$data['meta_keyword']
				);

				/*MySQL Hierarchical Data Closure Table Pattern*/
				$level       = 0;
				$resultPaths = $this->modelPath->where('category_id', $data['parent_id'])
					->orderBy('level', 'ASC')->get();

				foreach ($resultPaths as $key => $resultPath) {
					GiaoPhanDanhMucLienKet::insertByCateId($data['category_id'], $resultPath['path_id'], $level);
					$level++;
				}
				GiaoPhanDanhMucLienKet::insertByCateId($data['category_id'], $data['category_id'], $level);
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

	public function getCateogryById($categoryId = null)
	{
		if ($categoryId) {
			return $this->model->findOrFail($categoryId);
		}
	}

	public function getCategoryDesById($categoryId = null)
	{
		if ($categoryId) {
			return $this->modelDes->findOrFail($categoryId);
		}
	}

	/// UPDATE
	public function apiUpdate($model, array $data = [])
	{
		// TODO: Implement apiInsertOrUpdate() method.
		$data['name_slug'] = Str::slug($data['category_name'] . ' ' . $model->category_id);
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
					'name'             => $data['category_name'],
					'description'      => $data['description'],
					'meta_title'       => $data['meta_title'],
					'meta_description' => $data['meta_description'],
					'meta_keyword'     => $data['meta_keyword']
				];

				if ($dataDes) {
					$modelDes->fill($dataDes);
					$modelDes->save();
				} else {
					GiaoPhanDanhMucMoTa::insertByCateId(
						$categoryId,
						$data['category_name'],
						$data['description'],
						$data['meta_title'],
						$data['meta_description'],
						$data['meta_keyword']
					);
				}

				/*MySQL Hierarchical Data Closure Table Pattern*/
				$resultPaths = $this->modelPath->where('path_id', (int)$categoryId)
					->orderBy('level', 'ASC')->get();

				if ($resultPaths->count()) {
					foreach ($resultPaths as $key => $resultPath) {
						GiaoPhanDanhMucLienKet::fcDeleteByCateIdAndLevelDown($resultPath['category_id'], $resultPath['level']);

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
							GiaoPhanDanhMucLienKet::replaceByCateidAndPathAndLevel($resultPath['category_id'], $path_id, $level);
							$level++;
						}
					}
				} else {
					// Delete the path below the current one
					GiaoPhanDanhMucLienKet::fcDeleteByCateId($categoryId);

					// Fix for records with no paths
					$level = 0;

					$resultPathParents = $this->modelPath->where(
						'category_id',
						(int)$data['parent_id']
					)->orderBy('level', 'ASC')->get();

					foreach ($resultPathParents as $resultPathParent) {
						GiaoPhanDanhMucLienKet::insertByCateId($categoryId, $resultPathParent['path_id'], $level);
						$level++;
					}

					GiaoPhanDanhMucLienKet::replaceByCateidAndPathAndLevel($categoryId, $categoryId, $level);
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

	// DELETE
	private function _deleteById($cateId)
	{
		if ($cateId) {
			GiaoPhanDanhMucMoTa::fcDeleteByCateId($cateId);

			$resultPaths = $this->modelPath->where('path_id', '=', (int)$cateId)->get();
			foreach ($resultPaths as $itemPath) {
				GiaoPhanDanhMucLienKet::fcDeleteByPathId($itemPath->path_id);
				$resultlevels = $this->modelPath->where('category_id', '=', (int)$itemPath->category_id)->get();
				foreach ($resultlevels as $item) {
					GiaoPhanDanhMucLienKet::fcUpdateLevelByCateId($item->category_id, (int)$item->level);
				}
			}	
			GiaoPhanDanhMuc::fcDeleteByCateId($cateId);
			GiaoPhanTinTucDanhMuc::fcDeleteByCateId($cateId);
		}
	}

	// DELETE CATEGORY
	public function deleteCategory($model)
	{
		/**
		 * Save user with transaction to make sure all data stored correctly
		 */
		DB::beginTransaction();

		try {
			$cateId = $model->category_id;

			$this->_deleteById($cateId);
			DB::commit();
		} catch (\Exceptions $e) {
			DB::rollBack();
			throw $e;
			return false;
		}
	}

	// get list categories
	public function apiGetCategories($data = array(), $limit = 15)
	{
		$cate1 = 'cate1';
		$cd1   = 'cd1';

		$query = $this->modelPath
			->select(
				Tables::$giaophandanhmuc_lienkets . '.category_id AS category_id',
				$cate1 . '.parent_id',
				$cate1 . '.sort_order',
				GiaoPhanDanhMucLienKet::getRawCategoryName($cd1)
			)
			->gbByCategoryId()
			->ljoinCategory($cate1)
			->ljoinCategoryDescription($cd1);

		if (!empty($data['filter_name'])) {
			$query->filterLikeName($cd1, $data['filter_name']);
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
				GiaoPhanDanhMuc::insertForce($group->id, $group->father_id);
				$categoryId = $group->id;

				GiaoPhanDanhMucMoTa::insertByCateId(
					$group->id,
					$group->newsgroupname,
					'',
					$group->newsgroupnamenomark,
					'',
					''
				);

				/*MySQL Hierarchical Data Closure Table Pattern*/
				$level       = 0;
				$resultPaths = $this->modelPath->where('category_id', $group->father_id)
					->orderBy('level', 'ASC')->get();

				foreach ($resultPaths as $key => $resultPath) {
					GiaoPhanDanhMucLienKet::insertByCateId($group->id, $resultPath['path_id'], $level);

					$level++;
				}
				GiaoPhanDanhMucLienKet::insertByCateId($group->id, $group->id, $level);
			}
		} catch (\Exceptions $e) {
			DB::rollBack();

			return false;
		}

		DB::commit();
	}
}
