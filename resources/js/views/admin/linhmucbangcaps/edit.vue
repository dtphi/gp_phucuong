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
                        <!--<button
                            type="button"
                            @click="_submitInfo"
                            data-toggle="tooltip"
                            :title="$options.setting.btn_save_txt"
                            class="btn btn-primary"><i class="fa fa-save"></i>
                        </button>
                        <button type="button"
                                @click="_submitInfoBack"
                                data-toggle="tooltip"
                                title="Lưu"
                                class="btn btn-primary">{{$options.setting.btn_save_back_txt}}
                        </button>-->
                        <the-btn-back-list-page></the-btn-back-list-page>
                    </div>
                    <h1>{{$options.setting.panel_title}}</h1>
                    <breadcrumb></breadcrumb>
                </div>
            </div>
            <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-pencil"></i>{{$options.setting.frm_title}}</h3>
                    </div>

                    <div class="panel-body">
                        <!--<info-add-form
                            ref="formAddLinhMuc"></info-add-form>-->
                    </div>
                </div>
            </div>
        </validation-observer>
    </div>
</template>

<script>
    import {
        mapState,
        mapActions,
        mapGetters
    } from 'vuex';

    import InfoAddForm from 'com@admin/Form/LinhMucs/EditForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import TheBtnBackListPage from './components/TheBtnBackListPage';
    import {
        MODULE_MODULE_BANG_CAP_EDIT,
        MODULE_MODULE_SPECIAL_INFO_CAROUSEL
    } from 'store@admin/types/module-types';
    import {
        ACTION_RESET_NOTIFICATION_INFO,
        ACTION_SHOW_MODAL_EDIT
    } from 'store@admin/types/action-types';

    export default {
        name: 'InformationAdd',
        components: {
            Breadcrumb,
            InfoAddForm,
            TheBtnBackListPage
        },
        beforeCreate() {
            const linhmucId = parseInt(this.$route.params.linhmucId);
            if (!linhmucId) {
                return fn_redirect_url('admin/linh-mucs');
            }
        },
        data() {
            return {
                fullPage: true
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, [
                'specialInfoCarousel'
            ]),
            ...mapState(MODULE_MODULE_BANG_CAP_EDIT, {
                loading: state => state.loading,
                errors: state => state.errors,
                insertSuccess: state => state.insertSuccess
            }),
            _errors() {
                return this.errors.length;
            }
        },
        watch: {
            'insertSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_BANG_CAP_EDIT, [
                ACTION_RESET_NOTIFICATION_INFO,
                ACTION_SHOW_MODAL_EDIT,
                'update_special_carousel'
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

                this.update_special_carousel(this.specialInfoCarousel);
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.$refs.formAddLinhMuc._submitInfo();
                    }
                });
            },
            _submitInfoBack() {
                const _self = this;

                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.$refs.formAddLinhMuc._submitInfoBack();
                    }
                });
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]('');
            }
        },
        setting: {
            panel_title: 'Linh Mục',
            frm_title: 'Thêm Linh Mục',
            btn_save_txt: 'Lưu',
            btn_save_back_txt: 'Lưu trở về danh sách'
        },
        mounted() {
            const linhmucId = parseInt(this.$route.params.linhmucId);
            if (linhmucId) {
                this.[ACTION_SHOW_MODAL_EDIT](linhmucId);
            }
        },
    };
</script>
