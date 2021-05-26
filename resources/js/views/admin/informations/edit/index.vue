<template>
    <div id="content">
        <template v-if="_errors">
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p v-for="(err, idx) in _errorToArrs()" :key="idx">{{err}}</p>
            </div>
        </template>
        <template v-if="loading">
            <loading-over-lay
                :active.sync="loading"
                :is-full-page="fullPage"></loading-over-lay>
        </template>
        <validation-observer
            ref="observerInfo"
            @submit.prevent="_submitInfo">
            <div class="page-header">
                <div class="container-fluid">
                    <div class="pull-right">
                        <button type="button" @click="_submitInfo"
                                data-toggle="tooltip"
                                title="Cập nhật"
                                class="btn btn-primary"><i class="fa fa-save"></i>
                        </button>
                        <the-btn-back-list-page></the-btn-back-list-page>
                        <btn-add></btn-add>
                    </div>
                    <h1>{{$options.setting.panel_title}}</h1>
                    <breadcrumb></breadcrumb>
                </div>
            </div>
            <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-pencil"></i>{{$options.setting.frm_title}}</h3>
                    </div>
                    <div class="panel-body">
                        <info-edit-form
                            ref="formEditUser"></info-edit-form>
                    </div>
                </div>
            </div>
        </validation-observer>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import TheBtnBackListPage from '../components/TheBtnBackListPage';
    import InfoEditForm from 'com@admin/Form/Infos/EditForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import BtnAdd from '../components/TheBtnAdd';
    import {
        MODULE_INFO_EDIT,
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'InformationEdit',
        components: {
            TheBtnBackListPage,
            Breadcrumb,
            InfoEditForm,
            BtnAdd,
        },
        beforeCreate() {
            const infoId = parseInt(this.$route.params.infoId);
            if (!infoId) {
                return fn_redirect_url('admin/informations');
            }
        },
        data() {
            return {
                fullPage: false,
                updateLog: 0
            }
        },
        mounted() {
            const infoId = parseInt(this.$route.params.infoId);
            if (infoId) {
                this.[ACTION_SHOW_MODAL_EDIT](infoId);
            }
        },
        updated() {
            this.updateLog++;
            if (this.isNotExistValidate) {
                fn_redirect_url('admin/informations');
            }
        },
        computed: {
            ...mapState(MODULE_INFO_EDIT, [
                'loading',
                'updateSuccess',
                'errors',
                'infoId'
            ]),
            ...mapGetters(MODULE_INFO_EDIT, [
                'isNotExistValidate'
            ]),
            _errors() {
                return this.errors.length;
            }
        },
        watch: {
            'updateSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        methods: {
            ...mapActions(MODULE_INFO_EDIT, [
                ACTION_RESET_NOTIFICATION_INFO,
                ACTION_SHOW_MODAL_EDIT
            ]),
            _errorToArrs() {
                let errs = [];
                if (this.errors.length && typeof this.errors[0].messages !== "undefined") {
                    errs = Object.values(this.errors[0].messages);
                }

                if (Object.entries(errs).length === 0 && this.errors.length) {
                    errs.push(this.$options.setting.error_msg_system);
                }

                return errs;
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]();
            },
            _submitInfo() {
                const _self = this;
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.$refs.formEditUser._submitInfo();
                    }
                });
            }
        },
        setting: {
            panel_title: 'Tin Tuc',
            frm_title: 'Them tin tuc'
        }
    };
</script>
