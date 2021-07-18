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
        <template>
            <validation-observer
                ref="observerNewsGroup"
                @submit.prevent="_submitInfo">
                <div class="page-header">
                    <div class="container-fluid">
                        <h1>Cài đặt</h1>
                        <breadcrumb></breadcrumb>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-list"></i>Thay đổi</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a
                                            href="#tab-general"
                                            data-toggle="tab">Tổng quan</a>
                                    </li>
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-general">
                                        <div class="tab-content">
                                            <div class="form-group required">
                                                <label class="col-sm-1 control-label"
                                                       for="input-name">Logo</label>
                                                <div class="col-sm-10">
                                                    <!--<input type="text"
                                                           v-model="newsGroup.category_name"
                                                           placeholder="Tên nhóm tin" id="input-name"
                                                           class="form-control">-->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="input-info-duc-cha" class="col-sm-1 control-label"
                                                    >Banner</label
                                                >
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getImageAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="pull-right">
                                                        <button type="button"
                                                                @click="_submitInfo"
                                                                data-toggle="tooltip"
                                                                title="Cập nhật"
                                                                class="btn btn-primary">
                                                            <i class="fa fa-save"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </validation-observer>

        </template>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        fn_get_href_base_url
    } from '@app/api/utils/fn-helper';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        MODULE_MODULE_APP
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_IMAGE,
        ACTION_RESET_NOTIFICATION_INFO,
        ACTION_GET_SETTING
    } from 'store@admin/types/action-types';

    export default {
        name: 'SystemPage',
        components: {
            Breadcrumb,        
        },
        data() {
            const _self = this;

            const mm = new MM({
                el: '#modal-general-info-manager',
                api: {
                    baseUrl: window.origin + '/api/mmedia',
                    listUrl: 'list',
                    uploadUrl: 'upload',
                },
                onSelect: function (fi) {
                    if (typeof fi === "object") {
                        if (fi.hasOwnProperty('selected') && fi.selected) {
                            const pathImg = 'Image/NewPicture/';

                            if (fi.selected.hasOwnProperty('path')) {
                                if (this._selfCom.fn) {
                                    this._selfCom.fn(pathImg + fi.selected.path, fi.selected);
                                } else {
                                if (typeof this._selfCom.[ACTION_SET_IMAGE] == "function"){
                                    this._selfCom.[ACTION_SET_IMAGE](pathImg + fi.selected.path);
                                }
                                }

                                document.getElementById('media-file-manager-content').style = "display:none";
                            }
                        }
                    }
                },
                _selfCom: _self
            })

            return {
                fullPage: false,
                media: {},
                fn: null,
                mm: mm,
            };
        },
        watch: {
            'updateSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        computed: {
            ...mapState(MODULE_MODULE_APP, {
                loading: state => state.loading,
                errors: state => state.errors,
            }),
            ...mapGetters(MODULE_MODULE_APP, [
                'system',
                'updateSuccess'
            ]),
            _errors() {
                return this.errors.length;
            },
            _getImageAvatar() {
                if (this.system.banner_image != '') {
                    return fn_get_href_base_url(this.system.banner_image);
                }

                return '/images/no-photo.jpg';
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_APP, [
                ACTION_SET_IMAGE,
                ACTION_RESET_NOTIFICATION_INFO,
                ACTION_GET_SETTING,
                "ACTION_UPDATE_BANNER",
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
                _self.$refs.observerNewsGroup.validate().then((isValid) => {
                    if (isValid) {
                        _self.ACTION_UPDATE_BANNER();
                    }
                });
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]('');
            },
            _selectImage() {
                this.fn = null;
                document.getElementById('media-file-manager-content').style = "display:block";
            },
        },
        setting: {
            title: 'Cập nhật hệ thống',
            error_msg_system: 'Lỗi hệ thống !',
        },
        mounted() {
            this.[ACTION_GET_SETTING]();
        }
    };
</script>

<style>
#media-file-manager-content{
    position: absolute;
    z-index: 999999;
    top: 15px;
    right: 0px;
}
</style>