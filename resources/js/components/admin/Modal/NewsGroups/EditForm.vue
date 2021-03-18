<template>
    <transition name="modal-news-group-add">
        <div :class="classShow" :style="styleCss" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <validation-observer ref="observerNewsGroup" @submit.prevent="_submitInfo">
                    <div class="modal-content">
                        <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
                        <div class="modal-header">
                            <h4 class="modal-title">{{_getSetForm.title}}</h4>
                            <button type="button" class="close" aria-label="Close" @click="_close">
                                <span aria-hidden="true">
                                  <font-awesome-icon icon="times"/>
                                </span>
                            </button>
                        </div>
                        <template v-if="isShowParentInfo">
                            <news-group-current :parent-info="parentInfo"></news-group-current>
                        </template>
                        <div class="modal-body" v-if="groupData">
                            <!-- form start -->
                            <div class="form-horizontal">

                                <template name="card-body-add" v-if="_getSetForm.isAddFrom">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <validation-provider
                                                    name="news_group_name"
                                                    rules="required|max:191"
                                                    v-slot="{ errors }">
                                                    <input
                                                        v-model="groupData.newsgroupname"
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="News Group Name">
                                                    <span class="text-red">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Description</label>
                                            <div class="col-sm-10">
                                                <validation-provider
                                                    name="news_group_description"
                                                    rules="max:200"
                                                    v-slot="{ errors }">
                                                    <textarea
                                                        v-model="groupData.description"
                                                        class="form-control"
                                                        placeholder="Description"></textarea>
                                                    <span
                                                        class="text-red">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template name="card-body-edit" class="card-body" v-else>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <validation-provider
                                                    name="news_group_name"
                                                    rules="required|max:191"
                                                    v-slot="{ errors }">
                                                    <input
                                                        v-model="groupData.newsgroupname"
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="News Group Name">
                                                    <span class="text-red">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Description</label>
                                            <div class="col-sm-10">
                                                <validation-provider
                                                    name="news_group_description"
                                                    rules="max:200"
                                                    v-slot="{ errors }">
                                                    <textarea
                                                        v-model="groupData.description"
                                                        class="form-control"
                                                        placeholder="Description"></textarea>
                                                    <span class="text-red">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                </template>

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
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import NewsGroupCurrent from './TheGroupInfo';
    import {
        MODULE_NEWS_GROUP_EDIT_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_CLOSE_MODAL,
        ACTION_SET_LOADING,
        ACTION_UPDATE_NEWS_GROUP
    } from 'store@admin/types/action-types';

    export default {
        name: 'ModalEditForm',
        components: {NewsGroupCurrent},
        data() {
            return {
                fullPage: false,
                groupData: null,
                isShowParentInfo: false
            };
        },
        computed: {
            ...mapState(MODULE_NEWS_GROUP_EDIT_MODAL, {
                formAction: state => state.action,
                loading: state => state.loading,
                itemRoot: state => state.itemRoot
            }),
            ...mapGetters(MODULE_NEWS_GROUP_EDIT_MODAL, [
                'classShow',
                'styleCss',
                'newsGroup',
                'parentInfo'
            ]),

            _getSetForm() {
                let setting = this.$options.setting.edit;

                if (this.formAction) {
                    if (this._isEditAction()) {
                    	this.groupData = {...this.newsGroup};
                    } else {
                    	this._resetModal();
                    }
                }

                return setting;
            }
        },

        mounted() {
            this._close()
        },

        methods: {
            ...mapActions(MODULE_NEWS_GROUP_EDIT_MODAL, [
                ACTION_CLOSE_MODAL,
                ACTION_SET_LOADING,
                ACTION_UPDATE_NEWS_GROUP
            ]),

            async _resetModal() {
                this.$data.groupData = null;
                requestAnimationFrame(() => {
                    this.$refs.observerNewsGroup.reset()
                });
            },

            _close() {
                this.[ACTION_CLOSE_MODAL]()
            },

            _isEditAction() {
                return (this.formAction === this.$options.setting.edit.actionName)
            },

            async _submitInfo() {
                const _self = this;
                _self.[ACTION_SET_LOADING](true);
                await _self.$refs.observerNewsGroup.validate().then((isValid) => {
                    if (isValid) {
                      _self.[ACTION_UPDATE_NEWS_GROUP](_self.groupData);
                    } else {
                        _self.[ACTION_SET_LOADING](false);
                    }
                });
            }
        },
        setting: {
            btnCancelTxt: 'Close',
            edit: {
                actionName: 'edit',
                isParentShow: false,
                isAddFrom: false,
                title: 'Edit News Group',
                btnSubmitTxt: 'Update'
            }
        }
    };
</script>
