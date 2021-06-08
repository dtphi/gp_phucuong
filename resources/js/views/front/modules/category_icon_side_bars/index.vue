<template>
    <div
        v-if="_isExist"
        id="category-icon-side-bar-module"
        class="category">
        <h4 class="tit-common clr-blue">{{$options.setting.module_title}}</h4>
        <b-row>
            <category-item
                v-for="(item, idx) in _settingCategory"
                :key="idx"
                :idx="idx"
                :group="item"></category-item>
        </b-row>
    </div>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_CATEGORY_ICON_SIDE_BAR
    } from '@app/stores/front/types/module-types';
    import {
        ACTION_GET_SETTING,
    } from '@app/stores/front/types/action-types';
    import CategoryItem from './components/CategoryItem';

    export default {
        name: 'ModuleCategoryIconSideBar',
        components: {
            CategoryItem
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapState({
                settingCategorys: state => state.cfApp.setting.modules.module_category_icon_side_bar
            }),
            _isExist() {
                if (this.settingCategorys.hasOwnProperty('module_category_icon_side_bar_categories')) {
                    return this.settingCategorys.module_category_icon_side_bar_categories.length;
                }
                
                return 0;
            },
            _settingCategory() {
                return this.settingCategorys.module_category_icon_side_bar_categories;
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_CATEGORY_ICON_SIDE_BAR, [
                ACTION_GET_SETTING,
            ]),
        },
        setting: {
            module_title: 'Danh Mục',
        }
    };
</script>

<style lang="scss">
    @import './styles.scss';
</style>
