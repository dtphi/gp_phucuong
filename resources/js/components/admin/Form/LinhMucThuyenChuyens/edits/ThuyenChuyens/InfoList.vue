<template>
    <div class="table-responsive">
        <table id="info-thuyen-chuyen-list" 
            class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">Key</td>
                    <td>Value</td>
                </tr>
            </thead>
            <tbody v-for="(item, idx) in lists" :key="idx">
                <tr>
                    <td class="text-left">Từ giáo xứ</td>
                    <td>
                        <select class="form-control"
                            v-model="item.from_giao_xu_id">
                            <option value="0" :selected="item.from_giao_xu_id == null">Từ giáo xứ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Chức vụ</td>
                    <td>
                        <select class="form-control"
                            v-model="item.from_chuc_vu_id">
                            <option value="0" :selected="item.from_chuc_vu_id == null">Từ chức vụ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Từ ngày</td>
                    <td>
                        <cms-date-picker v-model="item.from_date" type="datetime"></cms-date-picker>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Đức cha</td>
                    <td>
                        <select class="form-control"
                            v-model="item.duc_cha_id">
                            <option value="0" :selected="item.duc_cha_id == null">Đức cha</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Ngày đến</td>
                    <td>
                        <cms-date-picker v-model="item.to_date" type="datetime"></cms-date-picker>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Chức vụ</td>
                    <td>
                        <select class="form-control"
                            v-model="item.chuc_vu_id">
                            <option value="0" :selected="item.chuc_vu_id == null">Chức vụ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Giáo xứ</td>
                    <td>
                        <select class="form-control"
                            v-model="item.giao_xu_id">
                            <option value="0" :selected="item.giao_xu_id == null">Giáo xứ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Cơ sở giáo phận</td>
                    <td>
                        <select class="form-control"
                            v-model="item.co_so_gp_id">
                            <option value="0" :selected="item.co_so_gp_id == null">Cơ sở giáo phận</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Dòng</td>
                    <td>
                        <select class="form-control"
                            v-model="item.dong_id">
                            <option value="0" :selected="item.dong_id == null">Dòng</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Ban chuyên trách</td>
                    <td>
                        <select class="form-control"
                            v-model="item.ban_chuyen_trach_id">
                            <option value="0" :selected="item.ban_chuyen_trach_id == null">Ban chuyên trách</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Du học</td>
                    <td>
                        <select class="form-control"
                            v-model="item.du_hoc">
                            <option value="0" :selected="item.du_hoc == null">Du học</option>
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
        MODULE_MODULE_LINH_MUC_EDIT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheInfoList',
        components: {
            BtnAdd,
        },
        props: {
            lists: {
                default: {}
            }
        },
        computed: {
        },
        methods: {
            ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
                'removeThuyenChuyen'
            ]),
            _removeItem(item) {
                this.removeThuyenChuyen({
                    action: 'removeThuyenChuyen',
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
