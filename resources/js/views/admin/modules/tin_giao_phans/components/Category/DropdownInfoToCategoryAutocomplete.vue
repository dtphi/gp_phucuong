<template>
    <li @click="_selectParentCategory()">
        <i v-if="isSelected" class="fa fa-plus-circle"></i>
        <a href="javascript:void(0);">{{category.name}}</a>
    </li>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_TIN_GIAO_PHAN
    } from 'store@admin/types/module-types';
    import {
        ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheDropdownCategory',
        props: {
            category: {
                default: {}
            }
        },
        data() {
            return {
                isSelected: false
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_TIN_GIAO_PHAN, [
                ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY
            ]),
            _selectParentCategory() {
                this.isSelected = true;
                this.[ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY](this.category);
            }
        },
        setting: {
            paren_category_txt: 'Danh mục hiển thị tin giáo phận'
        }
    };
</script>
