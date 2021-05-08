<template>
    <form class="form-horizontal">
      <loading-over-lay 
        :active.sync="loading" 
        :is-full-page="fullPage"></loading-over-lay>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab-link" data-toggle="tab">{{$options.setting.tab_link_title}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-link">
                <tab-data
                        role="tabpanel"
                        class="tab-pane active"
                        :module-data="moduleData"></tab-data>
            </div>
        </div>
    </form>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_VAN_KIEN
    } from 'store@admin/types/module-types';

    import {
        ACTION_GET_SETTING,
        ACTION_INSERT_SETTING
    } from 'store@admin/types/action-types';
   
    import TabData from './TabData';

    export default {
        name: 'TheModuleForm',
        components: {
            TabData,
        },
        data() {
            return {
                fullPage: false,
            };
        },
        computed: {
            ...mapState(MODULE_MODULE_VAN_KIEN, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_MODULE_VAN_KIEN, [
                'moduleData',
            ])
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_VAN_KIEN, [
                ACTION_GET_SETTING,
                ACTION_INSERT_SETTING
            ]),
            _submitInfo() {
                this.[ACTION_INSERT_SETTING](this.moduleData);
            },
        },
        setting: {
            tab_general_title: 'Tổng quan',
            tab_advance_title: 'Mở rộng',
            tab_link_title: 'Dữ liệu',
            tab_design_title: 'Màn hình',
            error_msg_system: 'Lỗi hệ thống !',
        }
    };
</script>
