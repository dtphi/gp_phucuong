<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base\ApiController;
use Illuminate\Http\Request;
use App\Http\Resources\Informations\InformationCollection;
use App\Http\Resources\Informations\InformationResource;
use App\Models\Information;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class InformationController extends ApiController
{
		protected $resourceName = 'information';

    public function index(Request $request) {
    	return new InformationCollection(Information::orderByDesc('id')->paginate());
		}

		public function show(Request $request, $id = null) {
			return new InformationResource(Information::findOrFail($id));
		}

	  public function store (Request $request) {
    $model = new Information();

    $storeResponse = $this->__handleStore($model, $request);

    if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
        return $storeResponse;
    }

    return $this->respondCreated("New {$this->resourceName} created.", $model->id);
  }

  public function update (Request $request, $id = null) {
    try {
        $model = Information::findOrFail($id);

    } catch (ModelNotFoundException $e) {
        Log::debug('News not found, Request ID = '. $id);
        return $this->respondNotFound();
    }

    return $this->__handleStore($model, $request);
  }

  public function destroy (Request $request, $id = null) {
  	try {
        $model = Information::findOrFail($id);
    } catch (ModelNotFoundException $e) {
        return $this->respondNotFound("No {$this->resourceName} found.");
    }

    $model->destroy($id);

    return $this->respondDeleted("{$this->resourceName} deleted.");
  }

  private function __handleStore(Information $model, &$request)
    {
        $requestParams = $request->all();
        $model->fill($requestParams);

        /**
         * Save news with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if (!$model->save()) {
            DB::rollBack();

            return $this->respondBadRequest();
        }

        DB::commit();

        return $this->respondUpdated();
    }
}
