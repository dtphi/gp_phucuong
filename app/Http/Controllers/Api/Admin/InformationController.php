<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index(Request $request) {
			return $request->user();
		}

		public function show(Request $request, $id = null) {
			return $request->user();
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
