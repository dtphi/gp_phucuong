<template>
    <form class="form-horizontal">
        <loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab-slide-image" data-toggle="tab">{{$options.setting.tab_slide_image_title}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-slide-image">
                <tab-slide-image
                    role="tabpanel"
                    class="tab-pane active"
                    :module-data="moduleData"></tab-slide-image>
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

    import TabSlideImage from './TabSlideImage';

    export default {
        name: 'TheModuleForm',
        components: {
            TabSlideImage,
        },
        data() {
            return {
                fullPage: false,
            };
        },
        computed: {
            ...mapState(MODULE_MODULE_NOI_BAT, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'moduleData',
            ])
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                ACTION_GET_SETTING,
                ACTION_INSERT_SETTING
            ]),
            _submitInfo() {
                this.[ACTION_INSERT_SETTING](this.moduleData);
            },
        },
        setting: {
            tab_slide_image_title: 'Hình ảnh bổ xung',
            error_msg_system: 'Lỗi hệ thống !',
        }
    };
</script>
