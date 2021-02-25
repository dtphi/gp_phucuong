<template>
    <transition name="modal-news-add">
        <div :class="classShow" :style="styleCss" data-keyboard="false">
            <div class="modal-dialog" style="display: contents;">
                <validation-observer ref="observerInfo" @submit.prevent="_submitInfo">
                    <div class="modal-content">
                        <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
                        <div class="modal-header">
                            <h4 class="modal-title">{{_getSetForm.title}}</h4>
                            <button type="button" class="close" @click="_close">
                                <span aria-hidden="true"><font-awesome-icon icon="times"/></span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div role="tabpanel">
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
                                <!-- form start -->
                                <div class="tab-content form-horizontal" v-if="_isShowBody">
                                    <tab-general
                                        role="tabpanel"
                                        class="tab-pane active"
                                        id="generalTab"
                                        :general-data="newsData"></tab-general>

                                    <tab-news-group
                                        role="tabpanel"
                                        class="tab-pane"
                                        :group-data="newsData"
                                        id="newsGroupTab"></tab-news-group>

                                    <tab-media-manager
                                        role="tabpanel"
                                        class="tab-pane"
                                        :group-data="newsData"
                                        id="mediaManagerTab"></tab-media-manager>

                                    <tab-setting
                                        role="tabpanel"
                                        class="tab-pane"
                                        id="settingTab"
                                        :setting-data="newsData"></tab-setting>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" @click="_close">
                                {{$options.setting.btnCancelTxt}}
                            </button>
                            <button type="button" class="btn btn-success" @click="_submitInfo">
                                {{_getSetForm.btnSubmitTxt}}
                            </button>
                        </div>
                    </div>
                </validation-observer>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
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
        MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_CLOSE_MODAL,
        ACTION_SET_LOADING,
        ACTION_INSERT_INFO,
        ACTION_UPDATE_INFO
    } from 'store@admin/types/action-types';
    import TabGeneral from './TabGeneral';
    import TabSetting from './TabSetting';
    import TabNewsGroup from './TabNewsGroup';
    import TabMediaManager from './TabImage';

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
                newsData: {}
            };
        },
        computed: {
            ...mapState(MODULE_INFO_MODAL, {
                formAction: state => state.action,
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_INFO_MODAL, [
                'classShow',
                'styleCss',
                'info',
            ]),

            _getSetForm() {
                let setting = this.$options.setting.add;

                if (this.formAction) {
                    setting = this.$options.setting[this.formAction];

                    if (this._isModalClose()) {
                        this._resetModal()
                    } else {
                        this.newsData = {...this.info}
                    }
                }

                return setting;
            }
        },

        mounted() {
            const _self = this;
            _self._close();
            EventBus.$on('item-selected-group', (groupItem) => {
                if ((typeof groupItem === 'object') && groupItem.hasOwnProperty('id')) {
                    _self.newsData.newsgroup_id = groupItem.id;
                    _self.newsData.newsgroupname = groupItem.newsgroupname;
                }
                console.log(`Oh, that's nice. It's gotten ${groupItem.id} clicks! :)`)
            });

            EventBus.$on('on-selected-image', (imgItem) => {
                if (imgItem.selected) {
                    _self.newsData.picture = imgItem.selected.path;
                } else {
                    _self.newsData.picture = null;
                }
            });
        },

        methods: {
            ...mapActions(MODULE_INFO_MODAL, [
                ACTION_CLOSE_MODAL,
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO,
                ACTION_UPDATE_INFO
            ]),

            async _resetModal() {
                this.$data.newsData = {};
                requestAnimationFrame(() => {
                    this.$refs.observerInfo.reset()
                });
            },

            _isShowBody() {
                return (this._isAddAction() || this._isEditAction())
            },

            _isAddAction() {
                return (this.formAction === this.$options.setting.add.actionName)
            },

            _isEditAction() {
                return (this.formAction === this.$options.setting.edit.actionName)
            },

            _isModalClose() {
                return (this.formAction === this.$options.setting.closeModal.actionName)
            },

            _close() {
                this.[ACTION_CLOSE_MODAL]()
            },

            async _submitInfo() {
                const _self = this;
                _self.[ACTION_SET_LOADING](true);
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        if (_self._isEditAction()) {
                            _self.[ACTION_UPDATE_INFO](_self.newsData)
                        } else {
                            _self.[ACTION_INSERT_INFO](_self.newsData)
                        }
                    } else {
                        _self.[ACTION_SET_LOADING](false)
                    }
                });
            }
        },
        setting: {
            btnCancelTxt: 'Close',
            nameTxt: 'Name',
            descriptionTxt: 'Description',
            newslinkTxt: 'News Link',
            add: {
                actionName: 'add',
                isAddFrom: true,
                title: 'Add News',
                btnSubmitTxt: 'Save'
            },
            edit: {
                actionName: 'edit',
                isAddFrom: false,
                title: 'Edit News',
                btnSubmitTxt: 'Update'
            },
            closeModal: {
                actionName: 'closeModal',
                isAddFrom: false,
                title: '',
                btnSubmitTxt: ''
            }
        }
    };
</script>
