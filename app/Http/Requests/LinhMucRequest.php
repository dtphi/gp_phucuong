<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $formData['ngay_thang_nam_sinh'] = isset($formData['ngay_thang_nam_sinh'])?$formData['ngay_thang_nam_sinh']: null;
        $formData['noi_sinh'] = isset($formData['noi_sinh'])?$formData['noi_sinh']:null;
        $formData['giao_xu_id'] = isset($formData['giao_xu_id'])?$formData['giao_xu_id']:null;
        $formData['ho_ten_cha'] = isset($formData['ho_ten_cha'])?$formData['ho_ten_cha']:null;
        $formData['ho_ten_me'] = isset($formData['ho_ten_me'])?$formData['ho_ten_me']:null;
        $formData['noi_rua_toi'] = isset($formData['noi_rua_toi'])?$formData['noi_rua_toi']:null;
        $formData['ngay_rua_toi'] = isset($formData['ngay_rua_toi'])?$formData['ngay_rua_toi']:null;
        $formData['noi_them_suc'] = isset($formData['noi_them_suc'])?$formData['noi_them_suc']:null;
        $formData['ngay_them_suc'] = isset($formData['ngay_them_suc'])?$formData['ngay_them_suc']:null;
        $formData['tieu_chung_vien'] = isset($formData['tieu_chung_vien'])?$formData['tieu_chung_vien']:null;
        $formData['ngay_tieu_chung_vien'] = isset($formData['ngay_tieu_chung_vien'])?$formData['ngay_tieu_chung_vien']:null;
        $formData['dai_chung_vien'] = isset($formData['dai_chung_vien'])?$formData['dai_chung_vien']:null;
        $formData['ngay_dai_chung_vien'] = isset($formData['ngay_dai_chung_vien'])?$formData['ngay_dai_chung_vien']:null;
        $formData['chucthanh_id'] = isset($formData['chucthanh_id'])?$formData['chucthanh_id']:null;
        $formData['image'] = isset($formData['image'])?$formData['image']:null;
        $formData['so_cmnd'] = isset($formData['so_cmnd'])?$formData['so_cmnd']:null;
        $formData['noicap_cmnd'] = isset($formData['noicap_cmnd'])?$formData['noicap_cmnd']:null;
        $formData['ngay_cap_cmnd'] = isset($formData['ngay_cap_cmnd'])?$formData['ngay_cap_cmnd']:null;
        $formData['trieu_dong'] = isset($formData['trieu_dong'])?$formData['trieu_dong']:0;
        $formData['ten_dong'] = isset($formData['ten_dong'])?$formData['ten_dong']:null;
        $formData['ngay_trieu_dong'] = isset($formData['ngay_trieu_dong'])?$formData['ngay_trieu_dong']:null;
        $formData['ngay_khan'] = isset($formData['ngay_khan'])?$formData['ngay_khan']:null;
        $formData['ngay_rip'] = isset($formData['ngay_rip'])?$formData['ngay_rip']:null;
        $formData['rip_giaoxu_id'] = isset($formData['rip_giaoxu_id'])?$formData['rip_giaoxu_id']:null;
        $formData['rip_ghi_chu'] = isset($formData['rip_ghi_chu'])?$formData['rip_ghi_chu']:null;

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
            //
        ];
    }
}
