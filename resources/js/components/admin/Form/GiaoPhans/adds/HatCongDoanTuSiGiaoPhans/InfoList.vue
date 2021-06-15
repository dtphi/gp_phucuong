<template>
    <div class="table-responsive">
        <table
                class="table table-striped table-bordered table-hover"
                v-for="(item, idx) in lists" :key="idx">
            <thead>
                <tr>
                    <td colspan="2">
                        {{item.giao_hat_id}}
                    </td>
                </tr>
                <tr>
                    <td>Giáo xứ</td>
                    <td>Trình trạng</td>
                </tr>
            </thead>
            <tbody v-for="(congDts, idx) in item.cong_doan_tu_sis" :key="idx">
                <tr>
                    <td>
                        <info-cong-doan-tu-si-autocomplete></info-cong-doan-tu-si-autocomplete>
                    </td>
                    <td>
                        <select
                            id="input-info-active"
                            class="form-control">
                            <option value="1" selected="selected">Xảy ra</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </td>
                </tr>
            
                <tr>
                    <td>{{$options.setting.info_action_title}}</td>
                    <td class="text-right">
                        <button 
                            type="button" 
                            @click="_removeItem(item)"
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

            <tfoot>
                <tr>
                    <td></td>
                    <td class="text-right">
                        <btn-add></btn-add>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>    
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import BtnAdd from './BtnAdd';
    import {
        MODULE_MODULE_GIAO_PHAN_ADD
    } from 'store@admin/types/module-types';
    import InfoGiaoXuAutocomplete from '../Groups/InfoGiaoXuAutocomplete';
    import InfoGiaoHatAutocomplete from '../Groups/InfoGiaoHatAutocomplete';
    import InfoGiaoDiemAutocomplete from '../Groups/InfoGiaoDiemAutocomplete';
    import InfoCongDoanTuSiAutocomplete from '../Groups/InfoCongDoanTuSiAutocomplete';

    export default {
        name: 'TheInfoList',
        components: {
            BtnAdd,
            InfoGiaoXuAutocomplete,
            InfoGiaoHatAutocomplete,
            InfoGiaoDiemAutocomplete,
            InfoCongDoanTuSiAutocomplete
        },
        props: {
            lists: {
                default: {}
            }
        },
        computed: {
        },
        methods: {
            ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
                'removeHatGiaoPhan'
            ]),
            _removeItem(item) {
                this.removeHatGiaoPhan({
                    action: 'removeHatGiaoPhan',
                    item: item
                });
            }
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
