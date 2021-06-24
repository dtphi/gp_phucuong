<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Auth;

class LinhmucRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @author : dtphi .
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $formData = $this->all();

        $formData['ten'] = isset($formData['ten']) ? $formData['ten']: null;
        $formData['ten_thanh_id'] = isset($formData['ten_thanh_id'])?$formData['ten_thanh_id']: null;
        $formData['ngay_thang_nam_sinh'] = isset($formData['ngay_thang_nam_sinh'])?$formData['ngay_thang_nam_sinh']: '';
        if (!empty($formData['ngay_thang_nam_sinh'])) {
            $date = date_create($formData['ngay_thang_nam_sinh']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_thang_nam_sinh'] = $dateAvailable;
        } else {
            $formData['ngay_thang_nam_sinh'] = now();
        }
        $formData['noi_sinh'] = isset($formData['noi_sinh'])?$formData['noi_sinh']:null;
        $formData['giao_xu_id'] = isset($formData['giao_xu_id'])?$formData['giao_xu_id']:null;
        $formData['ho_ten_cha'] = isset($formData['ho_ten_cha'])?$formData['ho_ten_cha']:null;
        $formData['ho_ten_me'] = isset($formData['ho_ten_me'])?$formData['ho_ten_me']:null;
        $formData['noi_rua_toi'] = isset($formData['noi_rua_toi'])?$formData['noi_rua_toi']:null;
        $formData['ngay_rua_toi'] = isset($formData['ngay_rua_toi'])?$formData['ngay_rua_toi']:'';
        if (!empty($formData['ngay_rua_toi'])) {
            $date = date_create($formData['ngay_rua_toi']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_rua_toi'] = $dateAvailable;
        } else {
            $formData['ngay_rua_toi'] = now();
        }
        $formData['noi_them_suc'] = isset($formData['noi_them_suc'])?$formData['noi_them_suc']:null;
        $formData['ngay_them_suc'] = isset($formData['ngay_them_suc'])?$formData['ngay_them_suc']: '';
        if (!empty($formData['ngay_them_suc'])) {
            $date = date_create($formData['ngay_them_suc']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_them_suc'] = $dateAvailable;
        } else {
            $formData['ngay_them_suc'] = now();
        }
        $formData['tieu_chung_vien'] = isset($formData['tieu_chung_vien'])?$formData['tieu_chung_vien']:null;
        $formData['ngay_tieu_chung_vien'] = isset($formData['ngay_tieu_chung_vien'])?$formData['ngay_tieu_chung_vien']: '';
        if (!empty($formData['ngay_tieu_chung_vien'])) {
            $date = date_create($formData['ngay_tieu_chung_vien']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_tieu_chung_vien'] = $dateAvailable;
        } else {
            $formData['ngay_tieu_chung_vien'] = now();
        }
        $formData['dai_chung_vien'] = isset($formData['dai_chung_vien'])?$formData['dai_chung_vien']:null;
        $formData['ngay_dai_chung_vien'] = isset($formData['ngay_dai_chung_vien'])?$formData['ngay_dai_chung_vien']:'';
        if (!empty($formData['ngay_dai_chung_vien'])) {
            $date = date_create($formData['ngay_dai_chung_vien']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_dai_chung_vien'] = $dateAvailable;
        } else {
            $formData['ngay_dai_chung_vien'] = now();
        }
        $formData['image'] = isset($formData['image'])?$formData['image']:null;
        $formData['so_cmnd'] = isset($formData['so_cmnd'])?$formData['so_cmnd']:null;
        $formData['noi_cap_cmnd'] = isset($formData['noi_cap_cmnd'])?$formData['noi_cap_cmnd']:null;
        $formData['ngay_cap_cmnd'] = isset($formData['ngay_cap_cmnd'])?$formData['ngay_cap_cmnd']:'';
        if (!empty($formData['ngay_cap_cmnd'])) {
            $date = date_create($formData['ngay_cap_cmnd']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_cap_cmnd'] = $dateAvailable;
        } else {
            $formData['ngay_cap_cmnd'] = now();
        }
        $formData['trieu_dong'] = isset($formData['trieu_dong'])?$formData['trieu_dong']:0;
        $formData['ten_dong'] = isset($formData['ten_dong'])?$formData['ten_dong']:null;
        $formData['ngay_trieu_dong'] = isset($formData['ngay_trieu_dong'])?$formData['ngay_trieu_dong']:'';
        if (!empty($formData['ngay_trieu_dong'])) {
            $date = date_create($formData['ngay_trieu_dong']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_trieu_dong'] = $dateAvailable;
        } else {
            $formData['ngay_trieu_dong'] = now();
        }
        $formData['ngay_khan'] = isset($formData['ngay_khan'])?$formData['ngay_khan']:'';
        if (!empty($formData['ngay_khan'])) {
            $date = date_create($formData['ngay_khan']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_khan'] = $dateAvailable;
        } else {
            $formData['ngay_khan'] = now();
        }
        $formData['ngay_rip'] = isset($formData['ngay_rip'])?$formData['ngay_rip']:'';
        if (!empty($formData['ngay_rip'])) {
            $date = date_create($formData['ngay_rip']);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $formData['ngay_rip'] = $dateAvailable;
        } else {
            $formData['ngay_rip'] = now();
        }
        $formData['rip_giao_xu_id'] = isset($formData['rip_giao_xu_id'])?$formData['rip_giao_xu_id']:null;
        $formData['rip_ghi_chu'] = isset($formData['rip_ghi_chu'])?$formData['rip_ghi_chu']:'';
        $formData['ghi_chu'] = isset($formData['ghi_chu'])?$formData['ghi_chu']:'';
        $formData['is_duc_cha'] = isset($formData['is_duc_cha'])?(int)$formData['is_duc_cha']:0;
        $formData['code'] = isset($formData['code'])?$formData['code']:'';
        $formData['phone'] = isset($formData['phone'])?$formData['phone']:'';
        $formData['email'] = isset($formData['email'])?$formData['email']:'';
        $formData['password'] = isset($formData['password'])?trim($formData['password']):'123789';
        $formData['password'] = Hash::make($formData['password']);
        $formData['update_user'] = isset(Auth::user()->id) ? Auth::user()->id : 0;

        $formData['bang_caps'] = isset($formData['bang_caps'])?$formData['bang_caps']:'';
        $formData['chuc_thanhs'] = isset($formData['chuc_thanhs'])?$formData['chuc_thanhs']:'';
        $formData['thuyen_chuyens'] = isset($formData['thuyen_chuyens'])?$formData['thuyen_chuyens']:'';
        $formData['van_thus'] = isset($formData['van_thus'])?$formData['van_thus']:'';

        $this->merge($formData);

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ten'       => 'required|max:50',
            'ten_thanh_id' => 'required',
            'ngay_thang_nam_sinh' => 'required',
            'ngay_rua_toi' => 'required'
        ];
    }
}
