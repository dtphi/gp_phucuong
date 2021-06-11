<template>
    <div class="tab-content">
        <div class="form-group">
            <div class="col-sm-12">
                <info-list :lists="chuc_thanhs"></info-list>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_NEWS_CATEGORY_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST,
    } from 'store@admin/types/action-types';
    import InfoList from './ChucThanhs/InfoList';

    export default {
        name: 'TabChucThanhForm',
        components: {
            InfoList
        },
        props: {
            groupData: {
                type: Object
            }
        },
        data() {
            return {
                chuc_thanhs: []
            }
        },
        computed: {
            ...mapGetters(MODULE_NEWS_CATEGORY, ['loading']),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, ['isOpen']),
        }
    };
</script>
