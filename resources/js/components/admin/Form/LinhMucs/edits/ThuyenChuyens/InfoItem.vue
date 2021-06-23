<template>
    <tbody>
        <tr>
            <td class="text-left">Từ giáo xứ</td>
            <td>
                <info-giao-xu-autocomplete 
                    @on-select-giao-xu="_selectThuyenChuyenFromGiaoXu" 
                    :name="item.fromgiaoxuName"
                    :key="`from_giao_xu_${item.id}`"></info-giao-xu-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Chức vụ</td>
            <td>
                <info-chuc-vu-autocomplete 
                    @on-select-chuc-vu="_selectThuyenChuyenFromChucVu" 
                    :name="item.fromchucvuName"
                    :key="`from_chuc_vu_${item.id}`"></info-chuc-vu-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Từ ngày</td>
            <td class="text-right">
                <div class="col-sm-2">
                    <label class="control-label">{{item.label_from_date}}</label>
                </div>
                <cms-date-picker v-model="item.from_date" type="datetime"></cms-date-picker>
            </td>
        </tr>
        <tr>
            <td class="text-left">Đức cha</td>
            <td>
                <info-duc-cha-autocomplete 
                    @on-select-chuc-cha="_selectThuyenChuyenDucCha" 
                    :name="item.ducchaName"
                    :key="`duc_cha_${item.id}`"></info-duc-cha-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Ngày đến</td>
            <td class="text-right">
                <div class="col-sm-2">
                    <label class="control-label">{{item.label_to_date}}</label>
                </div>
                <cms-date-picker v-model="item.to_date" type="datetime"></cms-date-picker>
            </td>
        </tr>
        <tr>
            <td class="text-left">Chức vụ đến</td>
            <td>
                <info-chuc-vu-autocomplete 
                    @on-select-chuc-vu="_selectThuyenChuyenToChucVu" 
                    :name="item.chucvuName"
                    :key="`to_chuc_vu_${item.id}`"></info-chuc-vu-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Giáo xứ đến</td>
            <td>
                <info-giao-xu-autocomplete 
                    @on-select-giao-xu="_selectThuyenChuyenToGiaoXu" 
                    :name="item.giaoxuName"
                    :key="`to_giao_xu_${item.id}`"></info-giao-xu-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Cơ sở giáo phận</td>
            <td>
                <info-co-so-giao-phan-autocomplete 
                    @on-select-co-so-giao-phan="_selectThuyenChuyenCoSoGiaoPhan" 
                    :name="item.cosogpName"
                    :key="`co_so_giao_phan_${item.id}`"></info-co-so-giao-phan-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Dòng</td>
            <td>
                <info-dong-autocomplete 
                    @on-select-dong="_selectThuyenChuyenDong"
                    :name="item.dongName"
                    :key="`dong_${item.id}`"></info-dong-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Ban chuyên trách</td>
            <td>
                <info-ban-chuyen-trach-autocomplete 
                    @on-select-ban-chuyen-trach="_selectThuyenChuyenBanChuyenTrach"
                    :name="item.banchuyentrachName"
                    :key="`ban_chuyen_trach_${item.id}`"></info-ban-chuyen-trach-autocomplete>
            </td>
        </tr>
        <tr>
            <td class="text-left">Du học</td>
            <td>
                <select class="form-control"
                    v-model="item.du_hoc">
                    <option value="0" :selected="item.du_hoc == 0">Du học 1</option>
                    <option value="1" :selected="item.du_hoc == 1">Du học 2</option>
                    <option value="2" :selected="item.du_hoc == 2">Du học 3</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="text-left">Quốc gia</td>
            <td>
                <select class="form-control"
                    v-model="item.quoc_gia">
                    <option value="0" :selected="item.quoc_gia == null">Quốc gia</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="text-left">Ghi chú</td>
            <td>
                <textarea class="form-control"
                    v-model="item.ghi_chu"></textarea>
            </td>
        </tr>
        <tr>
            <td class="text-left">Trình trạng</td>
            <td>
                <select class="form-control"
                    v-model="item.active">
                    <option value="1" :selected="item.active == 1">Xảy ra</option>
                    <option value="0" :selected="item.active == 0">Ẩn</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>{{$options.setting.info_action_title}}</td>
            <td class="text-right">
                <button 
                    type="button" 
                    @click="_removeThuyenChuyenItem()"
                    data-toggle="tooltip"
                    class="btn btn-default cms-btn">
                        <font-awesome-layers size="1x" style="background:MistyRose">
                            <font-awesome-icon icon="circle" style="color:Tomato"/>
                            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                        </font-awesome-layers>
                </button>
            </td>
        </tr>
    </tbody>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import BtnAdd from './BtnAdd';
    import linhMucMix from '@app/mixins/admin/linhmuc';
    import {
        MODULE_MODULE_LINH_MUC_EDIT
    } from 'store@admin/types/module-types';
    import InfoGiaoXuAutocomplete from '../../Groups/InfoGiaoXuAutocomplete';
    import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete';
    import InfoDucChaAutocomplete from '../../Groups/InfoDucChaAutocomplete';
    import InfoCoSoGiaoPhanAutocomplete from '../../Groups/InfoCoSoGiaoPhanAutocomplete';
    import InfoDongAutocomplete from '../../Groups/InfoDongAutocomplete';
    import InfoBanChuyenTrachAutocomplete from '../../Groups/InfoBanChuyenTrachAutocomplete';

    export default {
        name: 'TheInfoItem',
        mixins: [linhMucMix.tabData],
        components: {
            BtnAdd,
            InfoGiaoXuAutocomplete,
            InfoChucVuAutocomplete,
            InfoDucChaAutocomplete,
            InfoCoSoGiaoPhanAutocomplete,
            InfoDongAutocomplete,
            InfoBanChuyenTrachAutocomplete
        },
        props: {
            item: {
                default: {}
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
                'removeThuyenChuyen',
                'ACTION_UPDATE_DROPDOWN_FROM_GIAO_XU',
                'ACTION_UPDATE_DROPDOWN_FROM_CHUC_VU',
                'ACTION_UPDATE_DROPDOWN_FROM_DUC_CHA',
                'ACTION_UPDATE_DROPDOWN_TO_CHUC_VU',
                'ACTION_UPDATE_DROPDOWN_TO_GIAO_XU',
                'ACTION_UPDATE_DROPDOWN_CO_SO_GIAO_PHAN',
                'ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG',
                'ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH'
            ])
        },
        setting: {
            info_title: 'Tiêu đề',
            info_url_title: 'Url tiêu đề',
            info_author_titile: 'Tác giả',
            info_sort_order_title: 'Sắp xếp',
            info_action_title: 'Thực hiện',
            btn_image_sub_remove_txt: 'Xóa',
            btn_image_sub_add_txt: 'Thêm hình ảnh'
        }
    };
</script>
