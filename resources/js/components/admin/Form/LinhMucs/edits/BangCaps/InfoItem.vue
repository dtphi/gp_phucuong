<template>
    <tr>
        <td>
            <span v-show="!isEdit">{{item.name}}</span>
            <validation-provider v-show="isEdit"
                :name="`item_name${item.id}`"
                rules="required|max:255"
                v-slot="{ errors }">
                <input 
                    placeholder="Tên bằng cấp"
                    v-model="item.name" class="form-control" type="text"/>

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <span v-show="!isEdit">{{item.ghi_chu}}</span>
            <validation-provider v-show="isEdit"
                :name="`item_name${item.id}`"
                rules="max:500"
                v-slot="{ errors }">
                <textarea class="form-control"
                    v-model="item.ghi_chu"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <span v-show="!isEdit">{{_getLoaiText(item)}}</span>
            <select v-show="isEdit" class="form-control"
                v-model="item.type">
                <option value="0" :selected="item.type == 0">Loại 1</option>
                <option value="1" :selected="item.type == 1">Loại 2</option>
            </select>
        </td>
        <td>
            <span v-show="!isEdit">{{_getStatus(item)}}</span>
            <select v-show="isEdit" class="form-control"
                v-model="item.active">
                <option value="1" :selected="item.active == 1">Xảy ra</option>
                <option value="0" :selected="item.active == 0">Ẩn</option>
            </select>
        </td>
        <td class="text-right">
            <button  v-show="isEdit" @click="_updateBangCapForm()"
                    type="button"
                    data-toggle="tooltip"
                    title="Cập nhật bằng cấp" class="btn btn-primary cms-btn">
                    <i class="fa fa-save"></i>
            </button>
            <button @click="_openEditForm"
                    type="button" 
                    data-toggle="tooltip"
                    title="Sửa bằng cấp" class="btn btn-default cms-btn">
                    <i class="fa " :class="(isEdit)?'fa-angle-double-up':'fa-angle-double-down'"></i>
            </button>
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
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_LINH_MUC_EDIT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheInfoItem',
        props: {
            item: {
                default: {}
            }
        },
        data() {
            return {
                isEdit: false
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
                'removeBangCap'
            ]),
            _removeItem() {
                this.removeBangCap({
                    action: '',
                    item: this.item
                });
            },
            _openEditForm() {
                this.isEdit = !this.isEdit;
            },
            _updateBangCapForm() {
                console.log('update bang cap', this.item)
            },
            _getLoaiText(item) {
                let loaiBang = 'Loại 1';
                if (item.type == 1) loaiBang = 'Loại 2';
                return loaiBang;
            },
            _getStatus(item) {
                return (item.active == 1)?'Xảy ra':'Ẩn';
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
