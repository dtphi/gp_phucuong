<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admins\AdminCollection;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;

class AdminController extends Controller
{
	public function index(Request $request) {
    return new AdminCollection(Admin::paginate());
	}

	public function show(Request $request, $id = null) {
    return new AdminResource(Admin::findOrFail($id));
	}

  public function store (Request $request) {
  	return $request->user();
  }

  public function update (Request $request, $id = null) {
  	return $request->user();
  }

  public function destroy (Request $request, $id = null) {
  	return $request->user();
  }
}