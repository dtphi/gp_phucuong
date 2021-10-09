<template>
    <div>
        <info-list :lists="settingSachNoi"></info-list>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_MODULE_NOI_BAT,
        MODULE_INFO_EDIT,
        MODULE_MODULE_APP
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_DROPDOWN_CATEGORY_LIST,
        ACTION_ADD_INFO_TO_CATEGORY_LIST,
        ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA
    } from 'store@admin/types/action-types';
    import InfoList from './InfoList';

    export default {
        name: 'TheCategoryAutocompleteList',
        components: {
            InfoList
        },
        props: {
            moduleCode: {
                type: String
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_APP, ['texts']),
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingSachNoi',
            ]),
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, {
                'moduleUpdateResetSettingCategory':ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA
            }),
            ...mapActions(MODULE_NEWS_CATEGORY, {
                'moduleGetDropdownCategoryList':ACTION_GET_DROPDOWN_CATEGORY_LIST
            }),
            ...mapActions(MODULE_INFO_EDIT, {
                'moduleAddInfoToCategoryList':ACTION_ADD_INFO_TO_CATEGORY_LIST
            }),
        },
        setting: {
            paren_category_txt: 'Danh mục hiển thị thông báo'
        }
    };
</script>
