<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\EmailSubscribeModel;
use App\Http\Resources\EmailSubscribes\EmailCollection;
use App\Models\EmailSubscribe;
use App\Http\Common\Tables;
use DB;

final class EmailSubscribeService implements EmailSubscribeModel
{
  private $model = null;


  public function __construct()
  {
    $this->model = new EmailSubscribe();
  }

  public function apiInsert(array $data = [])
  {
    $this->model->fill($data);
    $data['email'];
    $this->model->save();
    return $this->model;
  }
}
