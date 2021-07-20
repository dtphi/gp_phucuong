<template>
    <tbody>
        <tr>
            <td>
                <info-co-so-giao-phan-autocomplete 
                    :coso="item" 
                    :key="item.id"></info-co-so-giao-phan-autocomplete>
            </td>
            <td>
                <select
                    v-model="item.active"
                    id="input-info-active"
                    class="form-control">
                    <option value="1" selected="selected">Xảy ra</option>
                    <option value="0">Ẩn</option>
                </select>
            </td>
            <td class="text-right">
                <button 
                    type="button" 
                    @click="_removeItem()"
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
    import {
        MODULE_MODULE_GIAO_PHAN_ADD
    } from 'store@admin/types/module-types';
    import InfoCoSoGiaoPhanAutocomplete from '../Groups/InfoCoSoGiaoPhanAutocomplete';

    export default {
        name: 'TheInfoList',
        components: {
            InfoCoSoGiaoPhanAutocomplete,
        },
        props: {
            item: {
                default: {}
            }
        },
        computed: {
        },
        methods: {
            ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
                'removeCoSoGiaoPhan'
            ]),
            _removeItem() {
                this.removeCoSoGiaoPhan({
                    action: 'removeCoSoGiaoPhan',
                    item: this.item
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
