<template>
    <div id="category-left-side-bar-module" style="min-height:500px">
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
                        <button
                            type="button"
                            @click="_submitInfo"
                            data-toggle="tooltip"
                            :title="$options.setting.btn_save_txt"
                            class="btn btn-primary"><i class="fa fa-save"></i>
                        </button>

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
                        <info-add-form
                            ref="formAddUser"></info-add-form>
                    </div>
                </div>
            </div>
        </validation-observer>
    </div>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';

    import InfoAddForm from './components/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';

    import {
        MODULE_MODULE_LOI_CHUA
    } from 'store@admin/types/module-types';
    import {
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'ModuleThongBao',
        components: {
            Breadcrumb,
            InfoAddForm,
        },
        data() {
            return {
                fullPage: true
            }
        },
        computed: {
            ...mapState(MODULE_MODULE_LOI_CHUA, {
                loading: state => state.loading,
                errors: state => state.errors,
                updateSuccess: state => state.updateSuccess
            }),
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
            ...mapActions(MODULE_MODULE_LOI_CHUA, [
                ACTION_RESET_NOTIFICATION_INFO
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
            _submitInfo() {
                const _self = this;
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.$refs.formAddSetting._submitInfo();
                    }
                });
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]('');
            }
        },
        setting: {
            panel_title: 'Module Thông Báo',
            frm_title: 'Thêm danh mục',
            btn_save_txt: 'Lưu',
        }
    };
</script>
