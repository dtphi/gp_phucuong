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
                    :is-form="$options.setting.isForm"
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
        MODULE_INFO_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_BY_ID,
        ACTION_UPDATE_INFO,
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
        name: 'InformationEditForm',
        
        components: {
            TabGeneral,
            TabMediaManager,
            TabAdvance,
            TabLink
        },

        data() {
            return {
                fullPage: false,
                file: null
            };
        },
        computed: {
            ...mapState(MODULE_INFO_EDIT, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_INFO_EDIT, [
                'info'
            ])
        },

        mounted() {
            const _self = this;
            EventBus.$on('on-selected-image', (imgItem) => {
                _self.$data.file = imgItem;
                _self._selectMainImg(imgItem);
            });
        },

        methods: {
            ...mapActions(MODULE_INFO_EDIT, [
                ACTION_UPDATE_INFO,
                ACTION_SET_IMAGE
            ]),

            _submitInfo() {
                const _self = this;
                _self.[ACTION_UPDATE_INFO](_self.info);
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
            btnSubmitTxt: 'Update',
            tab_general_title: 'Tổng quan',
            tab_advance_title: 'Mở rộng',
            tab_image_title: 'Hình ảnh',
            tab_link_title: 'Liên kết',
            tab_design_title: 'Màn hình',
            error_msg_system: 'Lỗi hệ thống !',
            isForm: 'edit'
        }
    };
</script>
