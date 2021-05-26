<template>
    <div class="table-responsive">
        <table id="info-list" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">{{$options.setting.info_title}}</td>
                    <td class="text-left">{{$options.setting.info_url_title}}</td>
                    <td class="text-left">{{$options.setting.info_author_titile}}</td>
                    <td class="text-left">{{$options.setting.info_sort_order_title}}</td>
                    <td class="text-left">Trạng thái</td>
                    <td class="text-left">Mở</td>
                    <td calss="text-right">{{$options.setting.info_action_title}}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, idx) in lists.value" :key="idx">
                    <td>
                        <validation-provider
                            :name="`item_title${item.id}`"
                            rules="required|max:191"
                            v-slot="{ errors }">
                                <input v-model="item.title" class="form-control" type="text"/>

                            <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </td>
                    <td>
                        <validation-provider
                            :name="`item_url_title${item.id}`"
                            rules="required|url|max:500"
                            v-slot="{ errors }">
                            <input v-model="item.url_title" class="form-control" type="text"/>

                            <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </td>
                    <td>
                        <validation-provider
                            :name="`item_author${item.id}`"
                            rules="max:255"
                            v-slot="{ errors }">
                            <input v-model="item.author" class="form-control" type="text"/>

                        <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </td>
                    <td>
                        <validation-provider
                            :name="`item_sort_order${item.id}`"
                            rules="numeric|max:11"
                            v-slot="{ errors }">
                            <input v-model="item.sort_order" class="form-control" type="number"/>

                            <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </td>
                    <td>
                        <select 
                            v-model="item.status">
                            <option value="1" :selected="item.status == 1">Xảy ra</option>
                            <option value="0" :selected="item.status == 0">Ẩn</option>
                        </select>
                    </td>
                    <td>
                        <select 
                            v-model="item.open">
                            <option value="0" :selected="item.open == 0">_blank</option>
                            <option value="1" :selected="item.open == 1">_self</option>
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
                    <td colspan="6"></td>
                    <td class="text-right">
                        <btn-add-setting :module-key="lists.key"></btn-add-setting>
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
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';
    import BtnAddSetting from '../Btn/BtnAddSetting';
    import {
        MODULE_MODULE_NOI_BAT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheInfoList',
        components: {
            BtnAddSetting,
        },
        props: {
            lists: {
                default: {}
            }
        },
        computed: {
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                'module_noi_bat_sach_nois_action_remove',
                'module_noi_bat_hanh_cac_thanhs_action_remove',
                'module_noi_bat_youtubes_action_remove'
            ]),
            _removeItem(item) {
                this[this.lists.key+'_action_remove']({
                    action: this.lists.key,
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
