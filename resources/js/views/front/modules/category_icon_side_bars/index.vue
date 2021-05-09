<template>
    <div id="category-icon-side-bar-module" class="category">
        <h4 class="tit-common clr-blue">Danh mục</h4>
        <b-row>
            <category-item 
                v-for="(item, idx) in settingCategory" 
                :key="idx"
                :idx="idx"
                :group="item"></category-item>
            <!--<b-col cols="4"><a class="d-block mb-4 bg-blue" href="#">Phụng vụ</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-red" href="#">Giáo luật</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-orange" href="#">Kinh thánh</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-green" href="#">Tài liệu</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-pink" href="#">Dòng tu</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-grow" href="#">Giáo lý</a></b-col>-->
        </b-row>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
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
                fullPage: true
            }
        },
        
        computed: {
            ...mapGetters(MODULE_MODULE_CATEGORY_ICON_SIDE_BAR, [
                'settingCategory',
            ])
        },

        created() {
            this.[ACTION_GET_SETTING]();
        },
        
        methods: {
             ...mapActions(MODULE_MODULE_CATEGORY_ICON_SIDE_BAR, [
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
    @import './styles.scss'
</style>