<?php

namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Requests\EmailSubscribeRequest;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use App\Http\Controllers\Api\Front\Services\Contracts\EmailSubscribeModel as newEmailSub;
use Illuminate\Http\Response as HttpResponse;

class EmailController extends Controller
{
  private $newEmailSub = null;

  public function __construct(newEmailSub $newEmailSub)
  {
      $this->newEmailSub = $newEmailSub;
  }

  public function store(EmailSubscribeRequest $request)
  {
    $storeResponse = $this->__handleStore($request);

    if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
      return $storeResponse;
    }

    return response()->json('success');
  }

  private function __handleStore(&$request)
  {
    $requestParams = $request->all();

    if ($this->newEmailSub->apiInsert($requestParams)) {
      return response()->json('OK!!');
    }

    return response()->json('failed!!');
  }
}
