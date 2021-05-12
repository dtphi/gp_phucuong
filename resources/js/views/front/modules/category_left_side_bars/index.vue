<template>
    <div
        v-if="_isExist"
        id="category-left-side-bar-module">
        <ul class="menu">
            <category-item
                v-for="(item, idx) in settingCategory"
                :key="idx"
                :group="item"></category-item>
        </ul>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR
    } from '@app/stores/front/types/module-types';
    import {
        ACTION_GET_SETTING,
    } from '@app/stores/front/types/action-types';
    import CategoryItem from './components/CategoryItem';

    export default {
        name: 'ModuleCategoryMenuLeft',
        components: {
            CategoryItem
        },
        data() {
            return {
                fullPage: true
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, [
                'settingCategory',
            ]),
            _isExist() {
                return this.settingCategory.length;
            }
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, [
                ACTION_GET_SETTING,
            ]),
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
            frm_title: 'Thêm danh mục Icon',
            btn_save_txt: 'Lưu',
        }
    };
</script>

<style lang="scss">
    @import './styles.scss';
</style>
