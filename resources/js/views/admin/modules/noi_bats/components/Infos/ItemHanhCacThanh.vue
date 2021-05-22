<template>
    <div>
        <div class="form-group">
            <label
                class="col-sm-2 control-label"
                for="input-parent-category-name">
                    <span data-toggle="tooltip"
                        data-original-title="(Tự động hoàn toàn)">Key</span>
            </label>
            <div class="col-sm-10">
                <input class="form-control" v-model="settingHanhCacThanh.key" type="text" disabled/>
            </div>
        </div>

        <info-list :lists="settingHanhCacThanh"></info-list>
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
        MODULE_MODULE_NOI_BAT,
        MODULE_INFO_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_DROPDOWN_CATEGORY_LIST,
        ACTION_ADD_INFO_TO_CATEGORY_LIST,
        ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA
    } from 'store@admin/types/action-types';
    import lodash from 'lodash';
    import InfoList from './InfoList';

    export default {
        name: 'TheCategoryAutocompleteList',
        components: {
            InfoList
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingHanhCacThanh',
            ]),
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA
            ]),
            ...mapActions(MODULE_NEWS_CATEGORY, [
                ACTION_GET_DROPDOWN_CATEGORY_LIST
            ]),
            ...mapActions(MODULE_INFO_EDIT, [
                ACTION_ADD_INFO_TO_CATEGORY_LIST
            ]),
        
            _initAddCategoryModule(cateList) {
                const _self = this;
                _.forEach(this.settingHanhCacThanh.value, function (categoryId) {
                    const isCategory = _.find(cateList, {category_id: categoryId})
                    if (isCategory) {
                        _self._addInfoToCategory(isCategory)
                    }
                })
            },
        },
        setting: {
            paren_category_txt: 'Danh mục hiển thị thông báo'
        }
    };
</script>

<style type="text/css" lang="css" scoped>
    .cms-ul-cate-dropdown {
        top: 35px;
        left: 15px;
    }

    .cms-ul-cate-dropdown > li > a:hover, .cms-dropdown-menu > li > a:focus {
        background-color: green !important
    }

    .cms-btn-dropdown {
        position: absolute;
        right: 0px;
        top: 0px;
        font-size: 0.5em;
    }
</style>
