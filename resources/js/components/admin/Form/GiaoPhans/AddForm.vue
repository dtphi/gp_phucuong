<template>
    <form class="form-horizontal">
        <loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>
        <ul class="nav nav-tabs">
            <li class="active">
                <a
                    href="#tab-general"
                    data-toggle="tab">{{$options.setting.tab_general_title}}</a>
            </li>
            <li>
                <a
                    href="#tab-mo-rong"
                    data-toggle="tab">{{$options.setting.tab_mo_rong_title}}</a>
            </li>
            <li>
                <a
                    href="#tab-bang-cap"
                    data-toggle="tab">{{$options.setting.tab_bang_cap_title}}</a>
            </li>
            <li>
                <a
                    href="#tab-chuc-thanh"
                    data-toggle="tab">{{$options.setting.tab_chuc_thanh_title}}</a>
            </li>
            <li>
                <a
                    href="#tab-van-thu"
                    data-toggle="tab">{{$options.setting.tab_van_thu_title}}</a>
            </li>
            <li>
                <a
                    href="#tab-thuyen-chuyen"
                    data-toggle="tab">{{$options.setting.tab_thuyen_chuyen_title}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
                <tab-general
                    role="tabpanel"
                    class="tab-pane active"
                    :general-data="info"></tab-general>
            </div>

            <div class="tab-pane" id="tab-mo-rong">
                <tab-mo-rong
                    role="tabpanel"
                    class="tab-pane"
                    :general-data="info"></tab-mo-rong>
            </div>

            <div class="tab-pane" id="tab-bang-cap">
                <tab-bang-cap
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-bang-cap>
            </div>

            <div class="tab-pane" id="tab-chuc-thanh">
                <tab-chuc-thanh
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-chuc-thanh>
            </div>

            <div class="tab-pane" id="tab-van-thu">
                <tab-van-thu
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-van-thu>
            </div>

            <div class="tab-pane" id="tab-thuyen-chuyen">
                <tab-thuyen-chuyen
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-thuyen-chuyen>
            </div>
        </div>
    </form>
</template>

<script>
    import {EventBus} from '@app/api/utils/event-bus';
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_LINH_MUC_ADD,
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
        ACTION_INSERT_INFO,
        ACTION_SET_IMAGE,
        ACTION_INSERT_INFO_BACK
    } from 'store@admin/types/action-types';
    import TabGeneral from './adds/TabGeneral';
    import TabMoRong from './adds/TabMoRong';
    import TabBangCap from './adds/TabBangCap';
    import TabChucThanh from './adds/TabChucThanh';
    import TabVanThu from './adds/TabVanThu';
    import TabThuyenChuyen from './adds/TabThuyenChuyen';

    export default {
        name: 'FormAdd',
        components: {
            TabGeneral,
            TabMoRong,
            TabBangCap,
            TabChucThanh,
            TabVanThu,
            TabThuyenChuyen
        },
        data() {
            return {
                fullPage: false,
                file: null
            };
        },
        computed: {
            ...mapState(MODULE_MODULE_LINH_MUC_ADD, {
                loading: state => state.loading
            }),
            ...mapGetters(MODULE_MODULE_LINH_MUC_ADD, [
                'info',
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
            ...mapActions(MODULE_MODULE_LINH_MUC_ADD, [
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO,
                ACTION_INSERT_INFO_BACK,
                ACTION_SET_IMAGE
            ]),
            _submitInfo() {
                this.[ACTION_INSERT_INFO](this.info);
            },
            _submitInfoBack() {
                this.[ACTION_INSERT_INFO_BACK](this.info);
            },
            _selectMainImg(file) {
                const image = {
                    basename: "",
                    dirname: "",
                    extension: "",
                    filename: "",
                    path: "",
                    size: 0,
                    thumb: "",
                    timestamp: '',
                    type: ""
                };
                if (typeof file === "object") {
                    let selected = image;

                    if (file.hasOwnProperty('selected') && file.selected) {
                        selected = file.selected;
                    }

                    this.[ACTION_SET_IMAGE](selected);
                }
            }
        },
        setting: {
            tab_general_title: 'Tổng quan',
            tab_mo_rong_title: 'Mở rộng',
            tab_bang_cap_title: 'Bằng Cấp',
            tab_chuc_thanh_title: 'Chức Thánh',
            tab_thuyen_chuyen_title: 'Thuyên Chuyển',
            tab_van_thu_title: 'Văn Thư',
            tab_special_info_title: 'Slide tin tức tiêu điểm',
            error_msg_system: 'Lỗi hệ thống !',
            isForm: 'add'
        }
    };
</script>
