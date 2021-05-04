<template>
    <div id="thong-bao-module" class="info">
        <h4 class="tit-common clr-orange"><img :src="iconBook" alt=""> Thông báo</h4>
        <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 3" :key="index">
            <span>
                <i class="status bg-green">Live</i>
            </span>
            <span>50 năm thành lập giáo phận Phú Cường</span>
            <span>Thanh Thúy</span>
        </a>
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
    import IconBook from 'v@front/assets/img/icon-book.png';

    export default {
        name: 'ModuleThongBao',
        components: {
        },
        data() {
            return {
                fullPage: true,

                iconBook: IconBook,
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

<style lang="scss">
    @import './styles.scss'
</style>