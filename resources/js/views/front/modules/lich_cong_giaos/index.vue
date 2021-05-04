<template>
    <div id="lich-cong-giao-module" class="calendar mt-4">
        <h4 class="title"><span>Lịch</span></h4>
        <b-calendar class="w-100"  locale="en-US"></b-calendar>
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
        name: 'ModuleLichCongGiao',
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