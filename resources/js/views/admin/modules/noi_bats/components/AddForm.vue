<template>
    <form class="form-horizontal">
        <loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab-sach-noi" data-toggle="tab">{{$options.setting.tab_sach_noi_title}}</a>
            </li>

            <li>
                <a href="#tab-youtube" data-toggle="tab">{{$options.setting.tab_youtube_title}}</a>
            </li>

            <li>
                <a href="#tab-hanh-cac-thanh" data-toggle="tab">{{$options.setting.tab_hanh_cac_thanh_title}}</a>
            </li>

            <li>
                <a href="#tab-banner" data-toggle="tab">{{$options.setting.tab_banner_title}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-sach-noi">
                <tab-sach-noi
                    role="tabpanel"
                    class="tab-pane active"
                    :module-data="modData"></tab-sach-noi>
            </div>

            <div class="tab-pane" id="tab-youtube">
                <tab-youtube
                    role="tabpanel"
                    class="tab-pane"
                    :module-data="modData"></tab-youtube>
            </div>

            <div class="tab-pane" id="tab-hanh-cac-thanh">
                <tab-hanh-cac-thanh
                    role="tabpanel"
                    class="tab-pane"
                    :module-data="modData"></tab-hanh-cac-thanh>
            </div>

            <div class="tab-pane" id="tab-banner">
                <tab-banner
                    role="tabpanel"
                    class="tab-pane"
                    :module-data="modData"></tab-banner>
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
        MODULE_MODULE_NOI_BAT
    } from 'store@admin/types/module-types';

    import {
        ACTION_GET_SETTING,
        ACTION_INSERT_SETTING
    } from 'store@admin/types/action-types';
    import mixinModule from '@app/mixins/admin/module';

    import TabSachNoi from './TabSachNoi';
    import TabYoutube from './TabYoutube';
    import TabHanhCacThanh from './TabHanhCacThanh';
    import TabBanner from './TabBanner';

    export default {
        name: 'TheModuleForm',
        mixins: [mixinModule],
        components: {
            TabSachNoi,
            TabYoutube,
            TabHanhCacThanh,
            TabBanner,
        },
        computed: {
            ...mapState(MODULE_MODULE_NOI_BAT, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_MODULE_NOI_BAT, {
                modData: 'moduleData',
            })
        },
        mounted() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
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
            tab_sach_noi_title: 'Sach Noi',
            tab_youtube_title: 'Youtube',
            tab_banner_title: 'Banner',
            tab_hanh_cac_thanh_title: 'Hạnh Các Thánh',
            error_msg_system: 'Lỗi hệ thống !',
        }
    };
</script>
