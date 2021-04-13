<template>
    <form class="form-horizontal">
      <loading-over-lay 
        :active.sync="loading" 
        :is-full-page="fullPage"></loading-over-lay>
      <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab-general" data-toggle="tab">{{$options.setting.tab_general_title}}</a>
        </li>
        <li>
            <a href="#tab-advance" data-toggle="tab">{{$options.setting.tab_advance_title}}</a>
        </li>
        <li>
            <a href="#tab-link" data-toggle="tab">{{$options.setting.tab_link_title}}</a>
        </li>
        <li>
            <a href="#tab-media-manager" data-toggle="tab">{{$options.setting.tab_image_title}}</a>
        </li>
      </ul>
      <div class="tab-content">

        <div class="tab-pane active" id="tab-general">
            <tab-general
                    role="tabpanel"
                    class="tab-pane active"
                    :general-data="info"></tab-general>
        </div>

        <div class="tab-pane" id="tab-advance">
            <tab-advance
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-advance>
        </div>

        <div class="tab-pane" id="tab-link">
            <tab-link
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-link>
        </div>

        <div class="tab-pane" id="tab-media-manager">
            <tab-media-manager ref="mediaManagerTab"
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-media-manager>
        </div>
      </div>
    </form>
</template>

<script>
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_INFO_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
        ACTION_INSERT_INFO,
        ACTION_SET_IMAGE
    } from 'store@admin/types/action-types';
    import TabGeneral from './TabGeneral';
    import TabAdvance from './TabAdvance';
    import TabLink from './TabLink';
    import TabMediaManager from './TabImage';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'FormAdd',
        components: {
            TabGeneral,
            TabAdvance,
            TabLink,
            TabMediaManager
        },
        data() {
            return {
                fullPage: false,
                file: null
            };
        },
        computed: {
            ...mapState(MODULE_INFO_ADD, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_INFO_ADD, [
                'info',
            ])
        },

        mounted() {
            const _self = this;
            EventBus.$on('on-selected-image', (imgItem) => {
                _self._selectMainImg(imgItem)
            });
        },

        methods: {
            ...mapActions(MODULE_INFO_ADD, [
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO,
                ACTION_SET_IMAGE
            ]),

            async _submitInfo() {
                const _self = this;
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.[ACTION_INSERT_INFO](_self.info)
                    }
                });
            },

            _back() {
                return fn_redirect_url('admin/news');
            },

            _selectMainImg(file) {
                if (typeof file === "object") {
                    if (file.hasOwnProperty('selected')) {
                        this.[ACTION_SET_IMAGE](file.selected);
                    }
                }
                //console.log(file, '->type:', typeof file, '=> has', file.hasOwnProperty('selected'))
            }
        },
        setting: {
            btnCancelTxt: 'Back',
            nameTxt: 'Name',
            descriptionTxt: 'Description',
            newslinkTxt: 'News Link',
            actionName: 'add',
            isAddFrom: true,
            title: 'Add News',
            btnSubmitTxt: 'Save',
            tab_general_title: 'Tổng quan',
            tab_advance_title: 'Mở rộng',
            tab_link_title: 'Liên kết',
            tab_image_title: 'Hình ảnh',
            tab_design_title: 'Màn hình',
            error_msg_system: 'Lỗi hệ thống !'
        }
    };
</script>
