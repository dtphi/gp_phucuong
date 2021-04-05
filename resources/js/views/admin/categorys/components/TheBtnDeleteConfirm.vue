<template>
	<button type="button" 
        data-toggle="tooltip" title="" 
        class="btn btn-default cms-btn" 
        @click="_showConfirm()" 
        data-original-title="Delete">
        <font-awesome-layers size="1x" style="background:MistyRose">
            <font-awesome-icon icon="circle" style="color:Tomato"/>
            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
        </font-awesome-layers>
    </button>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY
    } from 'store@admin/types/module-types';
    import {
        ACTION_DELETE_NEWS_GROUP_BY_ID,
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheBtnDeleteConfirm',
        props: {
            categoryId: {
                type: Number,
                default: 0,
                validator: function (value) {
                    return (value && Number.isInteger(value))
                }
            }
        },
        methods: {
            ...mapActions(MODULE_NEWS_CATEGORY, [
                ACTION_DELETE_NEWS_GROUP_BY_ID
            ]),

            _delete() {
                this.[ACTION_DELETE_NEWS_GROUP_BY_ID](this.categoryId); 
            },

            _showConfirm() {
                const _self = this;
                window.confirm('Are you sure?') ? _self._delete(): false;
            }
        }
    };
</script>
