<template>
    <div id="category-icon-side-bar-module" class="category">
        <h4 class="tit-common clr-blue">Danh mục</h4>
        <b-row>
            <b-col cols="4"><a class="d-block mb-4 bg-blue" href="#">Phụng vụ</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-red" href="#">Giáo luật</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-orange" href="#">Kinh thánh</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-green" href="#">Tài liệu</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-pink" href="#">Dòng tu</a></b-col>
            <b-col cols="4"><a class="d-block mb-4 bg-grow" href="#">Giáo lý</a></b-col>
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
        MODULE_INFO_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'ModuleCategoryIconSideBar',
        components: {
        },
        data() {
            return {
                fullPage: true
            }
        },
        
        methods: {
             
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
            frm_title: 'Thêm danh mục Icon',
            btn_save_txt: 'Lưu',
        }
    };
</script>
