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
                    :module-data="modData"></tab-data>
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
        MODULE_MODULE_TIN_GIAO_PHAN
    } from 'store@admin/types/module-types';

    import {
        ACTION_GET_SETTING,
        ACTION_INSERT_SETTING
    } from 'store@admin/types/action-types';

    import TabData from './TabData';
    import mixinModule from '@app/mixins/admin/module';

    export default {
        name: 'TheModuleForm',
        mixins: [mixinModule],
        components: {
            TabData,
        },
        computed: {
            ...mapState(MODULE_MODULE_TIN_GIAO_PHAN, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_MODULE_TIN_GIAO_PHAN, {
                modData: 'moduleData',
            })
        },
        mounted() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_TIN_GIAO_PHAN, [
                ACTION_GET_SETTING,
                ACTION_INSERT_SETTING
            ]),
            _submitFormInfo() {
                this.[ACTION_INSERT_SETTING](this.modData);
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
