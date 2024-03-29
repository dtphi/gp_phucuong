<?php

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('App\Http\Controllers\Api\Front')
  ->middleware('web')
  ->group(function () {
    Route::any('/app/get-setting', 'Base\ApiController@getSetting');
    Route::apiResource('/homes/get-list', 'HomeController');
    Route::get('/app/info/get-information-list', 'NewsController@list');
    Route::get('/app/info/get-information', 'NewsController@detail');
    Route::get('/app/info/get-information-tag', 'NewsController@getInfoTag');
    Route::get('/app/info/get-latest-information', 'NewsController@showLastedList');
    Route::get('/app/info/get-popular-information', 'NewsController@showPopularList');
    Route::get('/app/info/get-related-information', 'NewsController@showRelatedList');
    Route::get('/app/info/get-special-information', 'NewsController@showSpecialModuleList');
    Route::get('/app/get-data-module', 'ModuleController@showDataList');
    Route::get('/app/get-data-giao-xu', 'Base\ApiController@getGiaoXuList');
    Route::get('/app/get-data-hanh', 'Base\ApiController@getNgayLeList');
    Route::get('/app/get-data-giao-phan', 'Base\ApiController@getGiaoPhanList');
    Route::post('/app/get-data-giao-hat', 'Base\ApiController@getGiaoHatList');
    Route::post('/app/get-data-giao-xu-by-id', 'Base\ApiController@getGiaoXuListById');
    Route::get('/app/get-data-giao-xu/{id}', 'Base\ApiController@getGiaoXuDetail');
    Route::get('/app/get-data-linh-muc', 'Base\ApiController@getLinhMucList');
    Route::post('/app/get-data-hanh-by-id', 'Base\ApiController@getNgayLeListById');
    Route::get('/app/get-data-chuc-vu', 'Base\ApiController@getChucVuList');
    Route::post('/app/get-data-linh-muc-by-id', 'Base\ApiController@getLinhMucListById');
    Route::get('/app/get-detail-linh-muc/{id}', 'Base\ApiController@getLinhMucDetail');
    Route::get('/app/get-detail-linh-muc-update/{id}', 'Base\ApiController@getLinhMucUpdate');
    Route::post('/app/update-linh-muc-temp', 'Base\ApiController@updateLinhMucTemp');
    Route::apiResource('/email_sub/create', 'EmailController');
    Route::get('/app/dropdown-categories', 'Base\ApiController@listDropdownCategories');
    Route::get('/app/add-thuyen-chuyen', 'Base\ApiController@addThuyenChuyen');
    Route::get('/app/get-hoat-dong-su-vu/{id}', 'Base\ApiController@getHoatDongSuVu');
    Route::get('/app/get-hanh-detail', 'Base\ApiController@getNgayLeDetail');
    Route::get('/app/get-bo-nhiem-khac/{id}', 'Base\ApiController@getBoNhiemKhac');
    Route::post('/app/update-linh-muc-temp', 'Base\ApiController@updateLinhMucTemp');
    Route::get('/app/export-linh-muc/{id}', 'Base\ApiController@exportLinhMuc');
    Route::get('/app/calendar/getlist', 'CalenderController@getlist');
    Route::get('/app/calendar/getpam', 'CalenderController@getpam');
});

Route::namespace('App\Http\Controllers\Api\Admin')
  ->middleware(['web', 'secip'])
  ->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
});

Route::namespace('App\Http\Controllers\Api\Admin')
  ->middleware(['app.version', 'auth:sanctum', 'secip'])
  ->group(function () { 
    Route::get('/user', function (Request $request) {
      $user = $request->user();
      fn_get_user_rule($user);
      return $request->user();
    });
});

Route::namespace('App\Http\Controllers\Api\Admin')
  ->middleware(['web', 'secip'])
  ->group(function () { 
    Route::any('/linhmucadmin/linh-muc', function (Request $request) {
      if ($request->get('action') == 'linh.muc.list.filter') {
        return Helper::getLinhMucAllFilter($request->all());
      }
      return Helper::getLinhMucAll($request->all());
    });
});

Route::namespace('App\Http\Controllers\Api\Admin')
  ->middleware(['auth:sanctum', 'secip'])
  ->group(function () {
    Route::apiResource('users', 'AdminController');
    Route::get('/search-user', 'AdminController@search');
    Route::apiResource('news-groups', 'NewsGroupController');
    Route::get('/news-categories/dropdowns', 'NewsGroupController@dropdown');
    Route::apiResource('news', 'InformationController');
    Route::get('/informations/dropdowns', 'InformationController@dropdown');
    Route::apiResource('settings', 'SettingController');

    Route::apiResource('linh-mucs', 'LinhMucController');
    Route::get('lm-bo-nhiems/{infoId}', 'LinhMucController@listLinhMucBoNhiem');
    Route::get('lm-thuyen-chuyens/{infoId}', 'LinhMucController@listLinhMucThuyenChuyen');
    Route::apiResource('linh-muc-bang-caps', 'LinhMucBangCapController');
    Route::apiResource('linh-muc-chuc-thanhs', 'LinhMucChucThanhController');
    Route::apiResource('linh-muc-van-thus', 'LinhMucVanThuController');
    Route::apiResource('linh-muc-thuyen-chuyens', 'LinhMucThuyenChuyenController');
    Route::post('change-status-thuyen-chuyens','LinhMucThuyenChuyenController@changeStatus');
    Route::get('linh-muc-update/{infoId}', 'LinhMucController@listInfoLinhMucUpdate');
    Route::get('thuyen-chuyen-update/{infoId}', 'LinhMucController@listInfoThuyenChuyenUpdate');
    Route::get('export-linh-muc/{id}', 'LinhMucController@exportLinhMuc');

    Route::apiResource('giao-phans', 'GiaoPhanController');
    Route::apiResource('giao-hats', 'GiaoHatController');
    Route::apiResource('giao-xus', 'GiaoXuController');
    Route::get('gx-thuyen-chuyens/{id}', 'GiaoXuController@listGiaoXuThuyenChuyen');
    Route::get('giao-hats-by-giao-xus', 'GiaoXuController@listGiaoHats');
    Route::get('giao-xus-by-id-giao-hat/{id}', 'GiaoXuController@listGiaoXuByIdGiaoHat');
    Route::apiResource('giao-diems', 'GiaoDiemController');
    Route::apiResource('cong-doan-tu-sis', 'CongDoanTuSiController');
    Route::apiResource('co-sos', 'CoSoController');
    Route::apiResource('dongs', 'DongController');
    Route::apiResource('thanhs', 'ThanhController');
    Route::apiResource('chuc-vus', 'ChucVuController');
    Route::apiResource('le-chinhs', 'LeChinhController');
    Route::apiResource('ngay-les', 'NgayLeController');
    Route::apiResource('giao-phan/danh-mucs', 'GiaoPhanDanhMucController');
    Route::get('/danh-mucs/dropdowns', 'GiaoPhanDanhMucController@dropdown');
    Route::apiResource('giao-phan/tin-tucs', 'GiaoPhanTinTucController');
    Route::get('/tin-tucs/dropdowns', 'GiaoPhanTinTucController@dropdown');
    Route::apiResource('restrict-ips', 'RestrictIpController'); //RestrictIpController
    Route::get('search-ips','RestrictIpController@search');
    Route::post('change-status-ips','RestrictIpController@changeStatus');

    Route::apiResource('albums', 'AlbumsController'); //AlbumsController
    Route::get('search-albums','AlbumsController@search');
    Route::post('change-status-albums','AlbumsController@changeStatus');
    
    Route::apiResource('group-albums', 'GroupAlbumsController'); //GroupAlbumsController
    Route::get('search-group-albums','GroupAlbumsController@search');
    Route::post('change-status-group-albums','GroupAlbumsController@changeStatus');

    Route::post('/app/calendar/saveCalendar', 'CalenderController@saveCalendar');
    Route::get('/app/calendar/deleteCalendar', 'CalenderController@deleteCalendar');

    Route::any('/mmedia/{any}', function () {
    });
  });
  Route::namespace('\App\Http\Controllers\Api\Admin')
  ->group(function () {
	Route::get('/explorer/getlistdir','ExplorerController@getlistdir');
	Route::post('/explorer/upload','ExplorerController@upload');
	Route::get('/explorer/newFolder','ExplorerController@newFolder');
	Route::get('/explorer/delFile','ExplorerController@delFile');
	Route::get('/informations/getlisttacgias', 'TacgiasController@getlisttacgias');
	Route::get('/informations/deltacgias', 'TacgiasController@deltacgias');
	Route::get('/informations/addtacgias', 'TacgiasController@addtacgias');
	Route::get('/informations/edittacgias', 'TacgiasController@edittacgias');
	Route::get('/informations/editdatatacgias', 'TacgiasController@editdatatacgias');
  });
