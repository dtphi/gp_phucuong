<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface RestrictIpModel
{
  public function apiGetRestrictIps($data = array(), $limit = 5);

   public function apiGetDetail($id = null);

  public function apiUpdate($model, $data = []);

	public function apiDelete($model);
}
