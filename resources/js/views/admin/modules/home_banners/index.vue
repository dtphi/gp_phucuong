<template>
    <div id="content">
        <template v-if="$_module_errors">
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p v-for="(err, idx) in $_module_errorToArrs()" :key="idx">{{err}}</p>
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
                                            <div class="form-group">
                                                <div class="col-sm-12">
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
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="ƠN GỌI"
                                                        v-model="banners.title_on_goi"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_on_goi')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getOnGoiAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/danh-muc-tin/on-goi-linh-muc-241"
                                                        v-model="banners.url_on_goi"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="0"
                                                        v-model="banners.sort_on_goi"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="LỜI CHÚA"
                                                        v-model="banners.title_loi_chua"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_loi_chua')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getLoiChuaAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/danh-muc-tin/loi-chua-210"
                                                        v-model="banners.url_loi_chua"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="1"
                                                        v-model="banners.sort_loi_chua"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="VIDEO"
                                                        v-model="banners.title_video"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_video')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getVideoAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/video"
                                                        v-model="banners.url_video"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="2"
                                                        v-model="banners.sort_video"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="AUDIO/PODCAST"
                                                        v-model="banners.title_audio_podcast"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_audio_podcast')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getAudioPodcastAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="https://www.sachnoiconggiao.com/"
                                                        v-model="banners.url_audio_podcast"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="3"
                                                        v-model="banners.sort_audio_podcast"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="DANH SÁCH LINH MỤC"
                                                        v-model="banners.title_linh_muc"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_linh_muc')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getLinhMucAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/danh-muc-tin/giam-muc-18"
                                                        v-model="banners.url_linh_muc"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="4"
                                                        v-model="banners.sort_linh_muc"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="GIÁO XỨ TRONG GIÁO PHẬN"
                                                        v-model="banners.title_giao_xu"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_giao_xu')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getGiaoXuAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/danh-muc-tin/giao-phan-207"
                                                        v-model="banners.url_giao_xu"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="5"
                                                        v-model="banners.sort_giao_xu"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="THÔNG BÁO"
                                                        v-model="banners.title_thong_bao"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_thong_bao')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getThongBaoAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/danh-muc-tin/thong-bao-209"
                                                        v-model="banners.url_thong_bao"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="6"
                                                        v-model="banners.sort_thong_bao"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <input
                                                        placeholder="PHỤNG VỤ"
                                                        v-model="banners.title_phung_vu"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <span class="btn btn-default" @click="_selectImage('img_phung_vu')">
                                                        <i class="fa fa-image fa-fw"/>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="file animated fadeIn" style="height: 61px">
                                                    <div class="file-preview">
                                                        <img :src="_getPhungVuAvatar" class="thumb" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                        placeholder="http://haydesachnoipodcast.com/danh-muc-tin/phung-vu-213"
                                                        v-model="banners.url_phung_vu"
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                                <div class="col-sm-1">
                                                    <input
                                                        placeholder="7"
                                                        v-model="banners.sort_phung_vu"
                                                        class="form-control"
                                                        type="number"
                                                    />
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
    import mixinModule from '@app/mixins/admin/module';
    import {
        MODULE_MODULE_HOME_BANNER
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_IMAGE,
        ACTION_RESET_NOTIFICATION_INFO,
        ACTION_GET_SETTING
    } from 'store@admin/types/action-types';

    export default {
        name: 'HomeBannerPage',
        mixins: [mixinModule],
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
                                this._selfCom.media.path = pathImg + fi.selected.path;

                                if (this._selfCom.fn) {
                                    this._selfCom.fn(this._selfCom.media, fi.selected);
                                } else {
                                    if (typeof this._selfCom.moduleSetImage == "function"){
                                        this._selfCom.moduleSetImage(this._selfCom.media);
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
                media: {
                    type: '',
                    path: ''
                },
                fn: null,
                mm: mm,
            };
        },
        computed: {
            ...mapState(MODULE_MODULE_HOME_BANNER, {
                loading: state => state.loading,
                errors: state => state.errors,
            }),
            ...mapGetters(MODULE_MODULE_HOME_BANNER, [
                'banners',
                'updateSuccess'
            ]),
            _getOnGoiAvatar() {
                if (this.banners.img_on_goi != '') {
                    return fn_get_href_base_url(this.banners.img_on_goi);
                }

                return '/images/no-photo.jpg';
            },
            _getLoiChuaAvatar() {
                if (this.banners.img_loi_chua != '') {
                    return fn_get_href_base_url(this.banners.img_loi_chua);
                }

                return '/images/no-photo.jpg';
            },
            _getVideoAvatar() {
                if (this.banners.img_video != '') {
                    return fn_get_href_base_url(this.banners.img_video);
                }

                return '/images/no-photo.jpg';
            },
            _getAudioPodcastAvatar() {
                if (this.banners.img_audio_podcast != '') {
                    return fn_get_href_base_url(this.banners.img_audio_podcast);
                }

                return '/images/no-photo.jpg';
            },
            _getLinhMucAvatar() {
                if (this.banners.img_linh_muc != '') {
                    return fn_get_href_base_url(this.banners.img_linh_muc);
                }

                return '/images/no-photo.jpg';
            },
            _getGiaoXuAvatar() {
                if (this.banners.img_giao_xu != '') {
                    return fn_get_href_base_url(this.banners.img_giao_xu);
                }

                return '/images/no-photo.jpg';
            },
            _getThongBaoAvatar() {
                if (this.banners.img_thong_bao != '') {
                    return fn_get_href_base_url(this.banners.img_thong_bao);
                }

                return '/images/no-photo.jpg';
            },
            _getPhungVuAvatar() {
                if (this.banners.img_phung_vu != '') {
                    return fn_get_href_base_url(this.banners.img_phung_vu);
                }

                return '/images/no-photo.jpg';
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_HOME_BANNER, {
                'moduleSetImage': ACTION_SET_IMAGE,
                'moduleResetNotification': ACTION_RESET_NOTIFICATION_INFO,
                'moduleGetSetting': ACTION_GET_SETTING,
                'moduleUpdateBanner': "ACTION_UPDATE_BANNER",
            }),
            _submitInfo() {
                const _self = this;
                _self.$refs.observerNewsGroup.validate().then((isValid) => {
                    if (isValid) {
                        _self.moduleUpdateBanner();
                    }
                });
            },
            _selectImage(type) {
                this.fn = null;
                this.media.type = type;
                document.getElementById('media-file-manager-content').style = "display:block";
            },
        },
        setting: {
            title: 'Cập nhật hệ thống',
            error_msg_system: 'Lỗi hệ thống !',
        },
        mounted() {
            this.moduleGetSetting();
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