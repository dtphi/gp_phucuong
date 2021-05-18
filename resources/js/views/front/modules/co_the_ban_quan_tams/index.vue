<template>
    <div id="co-the-ban-quan-tam-module" class="mt-2 mb-3 new-care">
        <h4 class="tit-common clr-blue mb-3">Có thể bạn quan tâm</h4>
        <div class="list-new">
            <a class="d-block mb-2" href="#" v-for="(item, index) in 10" :key="index">
                <span><b-icon class="arrow-right-circle-fill" icon="arrow-right-circle-fill"></b-icon></span>
                <span class="mr-2">Giáo Xứ Rạch Kiến Mừng Đón Giáng Sinh</span>
                <span><b-icon class="alarm" icon="alarm"></b-icon> 27/12/2019</span>
            </a>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_THONG_BAO
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING
    } from 'store@front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModuleThongBao',
        components: {},
        data() {
            return {
                fullPage: true,
                iconBook: IconBook,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_THONG_BAO, [
                'settingCategory',
                'pageLists'
            ]),
            _isExist() {
                return this.settingCategory.length;
            }
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_THONG_BAO, [
                ACTION_GET_SETTING,
            ]),
            _getHref(info) {
                if (info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + fn_change_to_slug(info.name));
                }
            }
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
