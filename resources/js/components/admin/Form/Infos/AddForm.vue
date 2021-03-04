<template>
    <transition name="modal-news-add">
        <validation-observer ref="observerInfo" @submit.prevent="_submitInfo">
            <div class="modal-content" role="tabpanel">
                <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
                <div class="modal-header">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">General</a>
                            |
                        </li>
                        <li role="presentation" class="active">
                            <a href="#newsGroupTab" aria-controls="newsGroupTab" role="tab"
                               data-toggle="tab">News Group</a> |
                        </li>
                        <li role="presentation" class="active">
                            <a href="#mediaManagerTab" aria-controls="mediaManagerTab" role="tab"
                               data-toggle="tab">Image</a> |
                        </li>
                        <li role="presentation">
                            <a href="#settingTab" aria-controls="settingTab" role="tab" data-toggle="tab">Setting</a>
                        </li>
                    </ul>
                </div>

                <div class="modal-body">
                    <!-- form start -->
                    <div class="tab-content form-horizontal">
                        <tab-general
                            role="tabpanel"
                            class="tab-pane active"
                            id="generalTab"
                            :general-data="info"></tab-general>

                        <tab-news-group
                            role="tabpanel"
                            class="tab-pane"
                            :group-data="info"
                            id="newsGroupTab"></tab-news-group>

                        <tab-media-manager ref="mediaManagerTab"
                            role="tabpanel"
                            class="tab-pane"
                            :group-data="info"
                            :config-form="$options.setting"
                            id="mediaManagerTab"></tab-media-manager>

                        <tab-setting
                            role="tabpanel"
                            class="tab-pane"
                            id="settingTab"
                            :setting-data="info"></tab-setting>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" @click="_back">
                        {{$options.setting.btnCancelTxt}}
                    </button>
                    <button type="button" class="btn btn-success" @click="_submitInfo">
                        {{$options.setting.btnSubmitTxt}}
                    </button>
                </div>
            </div>
        </validation-observer>
    </transition>
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
        ACTION_INSERT_INFO
    } from 'store@admin/types/action-types';
    import TabGeneral from './TabGeneral';
    import TabSetting from './TabSetting';
    import TabNewsGroup from './TabNewsGroup';
    import TabMediaManager from './TabImage';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModalAddForm',
        components: {
            TabGeneral,
            TabNewsGroup,
            TabMediaManager,
            TabSetting
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

            EventBus.$on('item-selected-group', (groupItem) => {
                if ((typeof groupItem === 'object') && groupItem.hasOwnProperty('id')) {
                    _self.info.newsgroup_id = groupItem.id;
                    _self.info.newsgroupname = groupItem.newsgroupname;
                }
                console.log(`Oh, that's nice. It's gotten ${groupItem.id} clicks! :)`)
            });

            EventBus.$on('on-selected-image', (imgItem) => {
                if (imgItem.selected) {
                    _self.info.picture = imgItem.selected.path;
                    _self.file = imgItem;
                } else {
                    _self.info.picture = null;
                }
            });
        },

        methods: {
            ...mapActions(MODULE_INFO_ADD, [
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO
            ]),

            async _submitInfo() {
                const _self = this;
                _self.[ACTION_SET_LOADING](true);
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.[ACTION_INSERT_INFO](_self.info)
                    } else {
                        _self.[ACTION_SET_LOADING](false)
                    }
                });
            },

            _back() {
                return fn_redirect_url('admin/news');
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
        }
    };
</script>
