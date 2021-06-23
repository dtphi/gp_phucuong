<template>
    <div class="table-responsive">
        <table id="info-bang-cap-list" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">Tiêu đề</td>
                    <td class="text-left">Loại</td>
                    <td class="text-left">Ghi chú</td>
                    <td class="text-left">Trạng thái</td>
                    <td calss="text-right">{{$options.setting.info_action_title}}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, idx) in lists" :key="idx">
                    <td>
                        <validation-provider
                            :name="`item_name${item.id}`"
                            rules="required|max:255"
                            v-slot="{ errors }">
                            <input 
                                placeholder="Tiêu đề"
                                v-model="item.title" class="form-control" type="text"/>

                            <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </td>
                    <td>
                        <select class="form-control"
                            v-model="item.type">
                            <option value="0" :selected="item.type == 0">Dir</option>
                            <option value="1" :selected="item.type == 1">File</option>
                        </select>
                    </td>
                    <td>
                        <textarea class="form-control"
                            v-model="item.ghi_chu"></textarea>
                    </td>
                    <td>
                        <select class="form-control"
                            v-model="item.active">
                            <option value="1" :selected="item.active == 1">Xảy ra</option>
                            <option value="0" :selected="item.active == 0">Ẩn</option>
                        </select>
                    </td>
                    <td>
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
                    <td colspan="4"></td>
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
                'removeVanThu'
            ]),
            _removeItem(item) {
                this.removeVanThu({
                    action: 'removeVanThu',
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
