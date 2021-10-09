<template>
    <div>
        <i class="fa fa-minus-circle cms-text-red" 
            @click="_deleteCategory"></i>{{infoToCategory.name}}
    </div>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_TINTUC_GIAOPHAN_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_REMOVE_INFO_TO_CATEGORY_LIST
    } from 'store@admin/types/action-types';

    export default {
        name: 'GiaoPhanDanhMucItemEdit',
        props: {
            infoToCategory: {
                default: null
            }
        },
        methods: {
        	...mapActions(MODULE_MODULE_TINTUC_GIAOPHAN_EDIT, [
        		ACTION_REMOVE_INFO_TO_CATEGORY_LIST
        	]),
          _deleteCategory() {
              this[ACTION_REMOVE_INFO_TO_CATEGORY_LIST](this.infoToCategory)
          },
        },
    };
</script>
